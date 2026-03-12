<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Ride extends Model
{
    protected $fillable = [
        'event_id',
        'driver_registration_id',
        'transport_axis_id',
        'seats_capacity',
        'seats_reserved',
        'route_note',
        'assignment_source',
        'status',
    ];

    protected $casts = [
        'seats_capacity' => 'integer',
        'seats_reserved' => 'integer',
    ];

    // ── Relationships ──

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function driverRegistration(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'driver_registration_id');
    }

    public function transportAxis(): BelongsTo
    {
        return $this->belongsTo(TransportAxis::class);
    }

    public function ridePassengers(): HasMany
    {
        return $this->hasMany(RidePassenger::class);
    }

    public function passengers()
    {
        return $this->belongsToMany(
            Registration::class,
            'ride_passengers',
            'ride_id',
            'registration_id'
        )->withPivot('assignment_reason')->withTimestamps();
    }

    // ── Helpers ──

    public function getAvailableSeatsAttribute(): int
    {
        return max(0, $this->seats_capacity - $this->seats_reserved);
    }

    public function isFull(): bool
    {
        return $this->seats_reserved >= $this->seats_capacity;
    }

    public function addPassenger(Registration $passenger, string $reason = 'manual_override'): bool
    {
        if ($this->isFull()) {
            return false;
        }

        $this->passengers()->attach($passenger->id, ['assignment_reason' => $reason]);
        $this->increment('seats_reserved');

        return true;
    }

    public function removePassenger(Registration $passenger): bool
    {
        $detached = $this->passengers()->detach($passenger->id);

        if ($detached) {
            $this->decrement('seats_reserved');
        }

        return $detached > 0;
    }

    // ── Scopes ──

    public function scopeForEvent($query, $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    public function scopeAuto($query)
    {
        return $query->where('assignment_source', 'auto');
    }

    public function scopeManual($query)
    {
        return $query->where('assignment_source', 'manual');
    }

    public function scopeWithAvailableSeats($query)
    {
        return $query->whereColumn('seats_reserved', '<', 'seats_capacity');
    }
}
