<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Registration extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'phone',
        'area',
        'area_id',
        'nearest_landmark',
        'has_car',
        'available_seats',
        'willing_to_drive',
        'needs_ride',
        'assigned_driver_id',
        'driver_token',
    ];

    protected $casts = [
        'has_car' => 'boolean',
        'available_seats' => 'integer',
        'willing_to_drive' => 'boolean',
        'needs_ride' => 'boolean',
    ];

    // ── Boot ──

    protected static function booted(): void
    {
        static::creating(function (Registration $reg) {
            // Auto-generate driver token for drivers
            if ($reg->has_car && $reg->willing_to_drive) {
                $reg->driver_token = $reg->driver_token ?: Str::random(48);
            }
        });
    }

    // ── Relationships ──

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function areaModel(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    // Legacy: old manual assignment
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'assigned_driver_id');
    }

    public function passengers(): HasMany
    {
        return $this->hasMany(Registration::class, 'assigned_driver_id');
    }

    // New ride system
    public function driverRide(): HasOne
    {
        return $this->hasOne(Ride::class, 'driver_registration_id');
    }

    public function ridePassenger(): HasOne
    {
        return $this->hasOne(RidePassenger::class, 'registration_id');
    }

    // ── Scopes ──

    public function scopeDrivers($query)
    {
        return $query->where('has_car', true);
    }

    public function scopeEligibleDrivers($query)
    {
        return $query->where('has_car', true)
                     ->where('willing_to_drive', true)
                     ->where('available_seats', '>', 0);
    }

    public function scopeNeedsRide($query)
    {
        return $query->where('needs_ride', true);
    }

    public function scopeUnassigned($query)
    {
        return $query->where('needs_ride', true)
                     ->whereDoesntHave('ridePassenger');
    }

    public function scopeAssigned($query)
    {
        return $query->where('needs_ride', true)
                     ->whereHas('ridePassenger');
    }

    // ── Helpers ──

    public function isEligibleDriver(): bool
    {
        return $this->has_car && $this->willing_to_drive && $this->available_seats > 0;
    }

    public function isAssignedToRide(): bool
    {
        return $this->ridePassenger()->exists();
    }

    public function hasRideAsDriver(): bool
    {
        return $this->driverRide()->exists();
    }

    public function getFormattedPhoneAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        if (str_starts_with($phone, '0')) {
            $phone = substr($phone, 1);
        }
        if (! str_starts_with($phone, '963')) {
            $phone = '963' . $phone;
        }

        return $phone;
    }

    /**
     * Get the transport axis for this registration (via area).
     */
    public function getTransportAxisAttribute(): ?TransportAxis
    {
        return $this->areaModel?->transportAxis;
    }
}
