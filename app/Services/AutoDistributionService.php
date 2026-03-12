<?php

namespace App\Services;

use App\Models\Area;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Ride;
use App\Models\RidePassenger;
use App\Models\TransportAxis;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AutoDistributionService
{
    // ── Scoring Constants ──
    const SCORE_SAME_AREA      = 100;
    const SCORE_SAME_AXIS      = 70;
    const SCORE_NEIGHBOR_AXIS  = 40;
    const SCORE_FILL_EXISTING  = 15;  // Prefer filling existing rides over opening new ones
    const SCORE_LESS_SCATTER   = 10;  // Prefer rides with fewer remaining seats (less scatter)

    /**
     * Run automatic distribution for an event.
     *
     * @return array{assigned: int, unassigned: int, rides_created: int, details: array}
     */
    public function distribute(Event $event): array
    {
        return DB::transaction(function () use ($event) {

            // 1. Get eligible drivers who don't have a ride yet
            $drivers = $event->registrations()
                ->eligibleDrivers()
                ->whereDoesntHave('driverRide')
                ->with('areaModel.transportAxis')
                ->get();

            // 2. Get passengers needing a ride and not yet assigned
            $passengers = $event->registrations()
                ->unassigned()
                ->with('areaModel.transportAxis')
                ->get();

            // 3. Pre-load neighbor axis map
            $neighborMap = $this->buildNeighborMap();

            // 4. Create rides for eligible drivers
            $rides = collect();
            foreach ($drivers as $driver) {
                $axisId = $driver->areaModel?->transport_axis_id;
                $ride = Ride::create([
                    'event_id'                => $event->id,
                    'driver_registration_id'  => $driver->id,
                    'transport_axis_id'       => $axisId,
                    'seats_capacity'          => $driver->available_seats,
                    'seats_reserved'          => 0,
                    'assignment_source'       => 'auto',
                    'status'                  => 'pending',
                ]);
                $ride->setRelation('driverRegistration', $driver);
                $ride->driver_area_id = $driver->area_id;
                $ride->driver_axis_id = $axisId;
                $rides->push($ride);
            }

            // Also include existing rides with available seats
            $existingRides = Ride::forEvent($event->id)
                ->withAvailableSeats()
                ->with('driverRegistration.areaModel.transportAxis')
                ->get();

            foreach ($existingRides as $ride) {
                $ride->driver_area_id = $ride->driverRegistration->area_id;
                $ride->driver_axis_id = $ride->driverRegistration->areaModel?->transport_axis_id;
                if (!$rides->contains('id', $ride->id)) {
                    $rides->push($ride);
                }
            }

            // 5. Assign passengers using scoring
            $details = [];
            $assignedCount = 0;

            foreach ($passengers as $passenger) {
                $bestRide = null;
                $bestScore = -1;
                $bestReason = 'manual_override';

                $passengerAreaId = $passenger->area_id;
                $passengerAxisId = $passenger->areaModel?->transport_axis_id;

                foreach ($rides as $ride) {
                    if ($ride->isFull()) {
                        continue;
                    }

                    $score = 0;
                    $reason = 'manual_override';

                    // ── Phase 1: Same Area ──
                    if ($passengerAreaId && $ride->driver_area_id && $passengerAreaId === $ride->driver_area_id) {
                        $score += self::SCORE_SAME_AREA;
                        $reason = 'same_area';
                    }
                    // ── Phase 2: Same Axis ──
                    elseif ($passengerAxisId && $ride->driver_axis_id && $passengerAxisId === $ride->driver_axis_id) {
                        $score += self::SCORE_SAME_AXIS;
                        $reason = 'same_axis';
                    }
                    // ── Phase 3: Neighbor Axis ──
                    elseif ($passengerAxisId && $ride->driver_axis_id) {
                        $isNeighbor = isset($neighborMap[$ride->driver_axis_id])
                            && in_array($passengerAxisId, $neighborMap[$ride->driver_axis_id]);

                        if ($isNeighbor) {
                            $score += self::SCORE_NEIGHBOR_AXIS;
                            $reason = 'neighbor_axis';
                        }
                    }

                    // If no geographic match at all, skip this ride
                    if ($score === 0) {
                        continue;
                    }

                    // ── Bonus: Fill existing rides ──
                    if ($ride->seats_reserved > 0) {
                        $score += self::SCORE_FILL_EXISTING;
                    }

                    // ── Bonus: Less scatter (prefer rides closer to full) ──
                    $availableSeats = $ride->seats_capacity - $ride->seats_reserved;
                    if ($availableSeats <= 3) {
                        $score += self::SCORE_LESS_SCATTER;
                    }

                    if ($score > $bestScore) {
                        $bestScore = $score;
                        $bestRide = $ride;
                        $bestReason = $reason;
                    }
                }

                if ($bestRide) {
                    $bestRide->addPassenger($passenger, $bestReason);
                    // Update in-memory state
                    $bestRide->seats_reserved = $bestRide->seats_reserved;
                    $assignedCount++;
                    $details[] = [
                        'passenger_id'   => $passenger->id,
                        'passenger_name' => $passenger->name,
                        'ride_id'        => $bestRide->id,
                        'driver_name'    => $bestRide->driverRegistration->name,
                        'reason'         => $bestReason,
                        'score'          => $bestScore,
                    ];
                }
            }

            $unassignedCount = $passengers->count() - $assignedCount;

            return [
                'assigned'      => $assignedCount,
                'unassigned'    => $unassignedCount,
                'rides_created' => $rides->where('assignment_source', 'auto')->count(),
                'details'       => $details,
            ];
        });
    }

    /**
     * Clear all auto-generated rides and assignments for an event.
     */
    public function clearAutoDistribution(Event $event): int
    {
        return DB::transaction(function () use ($event) {
            $autoRides = Ride::forEvent($event->id)->auto()->get();
            $count = $autoRides->count();

            foreach ($autoRides as $ride) {
                $ride->passengers()->detach();
                $ride->delete();
            }

            return $count;
        });
    }

    /**
     * Get distribution summary for an event.
     */
    public function getSummary(Event $event): array
    {
        $totalNeedRide = $event->registrations()->needsRide()->count();
        $assignedCount = $event->registrations()->assigned()->count();
        $unassignedCount = $event->registrations()->unassigned()->count();
        $eligibleDrivers = $event->registrations()->eligibleDrivers()->count();
        $totalSeats = $event->registrations()->eligibleDrivers()->sum('available_seats');
        $ridesCount = $event->rides()->count();
        $autoRidesCount = $event->rides()->auto()->count();

        // Per-axis breakdown
        $axisBreakdown = $this->getAxisBreakdown($event);

        return [
            'total_need_ride'   => $totalNeedRide,
            'assigned'          => $assignedCount,
            'unassigned'        => $unassignedCount,
            'eligible_drivers'  => $eligibleDrivers,
            'total_seats'       => $totalSeats,
            'rides_count'       => $ridesCount,
            'auto_rides_count'  => $autoRidesCount,
            'axis_breakdown'    => $axisBreakdown,
        ];
    }

    /**
     * Get per-axis breakdown of supply vs demand.
     */
    private function getAxisBreakdown(Event $event): array
    {
        $axes = TransportAxis::active()->with('areas')->get();
        $breakdown = [];

        foreach ($axes as $axis) {
            $areaIds = $axis->areas->pluck('id')->toArray();

            $needsRide = $event->registrations()
                ->needsRide()
                ->whereIn('area_id', $areaIds)
                ->count();

            $drivers = $event->registrations()
                ->eligibleDrivers()
                ->whereIn('area_id', $areaIds)
                ->count();

            $seats = $event->registrations()
                ->eligibleDrivers()
                ->whereIn('area_id', $areaIds)
                ->sum('available_seats');

            $assigned = $event->registrations()
                ->assigned()
                ->whereIn('area_id', $areaIds)
                ->count();

            $breakdown[] = [
                'axis_id'     => $axis->id,
                'axis_name'   => $axis->name,
                'needs_ride'  => $needsRide,
                'drivers'     => $drivers,
                'total_seats' => $seats,
                'assigned'    => $assigned,
                'unassigned'  => $needsRide - $assigned,
                'surplus'     => $seats - $needsRide,
            ];
        }

        return $breakdown;
    }

    /**
     * Build a map of axis_id => [neighbor_axis_ids].
     */
    private function buildNeighborMap(): array
    {
        $rows = DB::table('axis_neighbors')
            ->orderBy('priority')
            ->get();

        $map = [];
        foreach ($rows as $row) {
            $map[$row->axis_id][] = $row->neighbor_axis_id;
        }

        return $map;
    }
}
