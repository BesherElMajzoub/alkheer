<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Ride;
use App\Models\RidePassenger;
use App\Services\AutoDistributionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminRideController extends Controller
{
    public function __construct(
        private AutoDistributionService $distributionService
    ) {}

    /**
     * Show the ride management page for an event.
     */
    public function index(Event $event)
    {
        $summary = $this->distributionService->getSummary($event);

        $rides = Ride::forEvent($event->id)
            ->with([
                'driverRegistration.areaModel.transportAxis',
                'passengers.areaModel',
            ])
            ->get();

        $unassigned = $event->registrations()
            ->unassigned()
            ->with('areaModel.transportAxis')
            ->get();

        $availableDrivers = $event->registrations()
            ->eligibleDrivers()
            ->whereDoesntHave('driverRide')
            ->with('areaModel')
            ->get();

        return view('admin.events.rides', compact(
            'event', 'summary', 'rides', 'unassigned', 'availableDrivers'
        ));
    }

    /**
     * Run auto distribution.
     */
    public function autoDistribute(Event $event)
    {
        $result = $this->distributionService->distribute($event);

        $msg = "تم التوزيع: {$result['assigned']} راكب تم توزيعهم، {$result['unassigned']} بدون توزيع، {$result['rides_created']} رحلة جديدة";

        return back()->with('success', $msg);
    }

    /**
     * Clear auto distribution.
     */
    public function clearAuto(Event $event)
    {
        $count = $this->distributionService->clearAutoDistribution($event);

        return back()->with('success', "تم حذف {$count} رحلة تلقائية");
    }

    /**
     * Manually add a passenger to a ride.
     */
    public function addPassenger(Request $request, Event $event)
    {
        $request->validate([
            'ride_id'         => 'required|exists:rides,id',
            'registration_id' => 'required|exists:registrations,id',
        ]);

        $ride = Ride::where('id', $request->ride_id)
            ->where('event_id', $event->id)
            ->firstOrFail();

        $passenger = Registration::where('id', $request->registration_id)
            ->where('event_id', $event->id)
            ->firstOrFail();

        // Validate: not already assigned
        if ($passenger->isAssignedToRide()) {
            return back()->with('error', 'هذا الشخص معيّن بالفعل في رحلة أخرى');
        }

        // Validate: not the driver
        if ($ride->driver_registration_id === $passenger->id) {
            return back()->with('error', 'لا يمكن إضافة السائق كراكب في رحلته');
        }

        if ($ride->isFull()) {
            return back()->with('error', 'لا توجد مقاعد متاحة في هذه الرحلة');
        }

        $ride->addPassenger($passenger, 'manual_override');

        return back()->with('success', "تم إضافة {$passenger->name} إلى الرحلة");
    }

    /**
     * Remove a passenger from a ride.
     */
    public function removePassenger(Request $request, Event $event)
    {
        $request->validate([
            'ride_id'         => 'required|exists:rides,id',
            'registration_id' => 'required|exists:registrations,id',
        ]);

        $ride = Ride::where('id', $request->ride_id)
            ->where('event_id', $event->id)
            ->firstOrFail();

        $passenger = Registration::findOrFail($request->registration_id);

        $ride->removePassenger($passenger);

        return back()->with('success', "تم إزالة {$passenger->name} من الرحلة");
    }

    /**
     * Move a passenger from one ride to another.
     */
    public function movePassenger(Request $request, Event $event)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'from_ride_id'    => 'required|exists:rides,id',
            'to_ride_id'      => 'required|exists:rides,id',
        ]);

        $fromRide = Ride::where('id', $request->from_ride_id)->where('event_id', $event->id)->firstOrFail();
        $toRide = Ride::where('id', $request->to_ride_id)->where('event_id', $event->id)->firstOrFail();
        $passenger = Registration::findOrFail($request->registration_id);

        if ($toRide->isFull()) {
            return back()->with('error', 'الرحلة المستهدفة ممتلئة');
        }

        DB::transaction(function () use ($fromRide, $toRide, $passenger) {
            $fromRide->removePassenger($passenger);
            $toRide->addPassenger($passenger, 'manual_override');
        });

        return back()->with('success', "تم نقل {$passenger->name}");
    }

    /**
     * Create a manual ride.
     */
    public function createManualRide(Request $request, Event $event)
    {
        $request->validate([
            'driver_registration_id' => 'required|exists:registrations,id',
        ]);

        $driver = Registration::where('id', $request->driver_registration_id)
            ->where('event_id', $event->id)
            ->where('has_car', true)
            ->where('willing_to_drive', true)
            ->firstOrFail();

        // Check if driver already has a ride
        if ($driver->hasRideAsDriver()) {
            return back()->with('error', 'هذا السائق لديه رحلة بالفعل');
        }

        Ride::create([
            'event_id'               => $event->id,
            'driver_registration_id' => $driver->id,
            'transport_axis_id'      => $driver->areaModel?->transport_axis_id,
            'seats_capacity'         => $driver->available_seats,
            'seats_reserved'         => 0,
            'assignment_source'      => 'manual',
            'status'                 => 'pending',
        ]);

        return back()->with('success', "تم إنشاء رحلة يدوية للسائق {$driver->name}");
    }

    /**
     * Delete a ride.
     */
    public function deleteRide(Event $event, Ride $ride)
    {
        if ($ride->event_id !== $event->id) {
            abort(404);
        }

        $ride->passengers()->detach();
        $ride->delete();

        return back()->with('success', 'تم حذف الرحلة');
    }
}
