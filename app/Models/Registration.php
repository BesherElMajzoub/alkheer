<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Registration extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'phone',
        'area',
        'has_car',
        'available_seats',
        'assigned_driver_id',
    ];

    protected $casts = [
        'has_car' => 'boolean',
        'available_seats' => 'integer',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'assigned_driver_id');
    }

    public function passengers(): HasMany
    {
        return $this->hasMany(Registration::class, 'assigned_driver_id');
    }

    public function scopeDrivers($query)
    {
        return $query->where('has_car', true);
    }

    public function scopeNeedsRide($query)
    {
        return $query->where('has_car', false);
    }

    public function scopeUnassigned($query)
    {
        return $query->whereNull('assigned_driver_id')->where('has_car', false);
    }

    public function getFormattedPhoneAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        if (str_starts_with($phone, '0')) {
            $phone = ''.substr($phone, 1);
        }
        if (! str_starts_with($phone, '966')) {
            $phone = ''.$phone;
        }

        return $phone;
    }
}
