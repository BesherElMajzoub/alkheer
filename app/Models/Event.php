<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'name',
        'description',
        'location',
        'event_date',
        'max_attendees',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'is_active' => 'boolean',
        'max_attendees' => 'integer',
    ];

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now())
                     ->where('is_active', true)
                     ->orderBy('event_date', 'asc');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getRegistrationsCountAttribute(): int
    {
        return $this->registrations()->count();
    }

    public function getDriversCountAttribute(): int
    {
        return $this->registrations()->where('has_car', true)->count();
    }

    public function getNeedsRideCountAttribute(): int
    {
        return $this->registrations()->where('has_car', false)->count();
    }

    public function isFull(): bool
    {
        if (is_null($this->max_attendees)) {
            return false;
        }
        return $this->registrations()->count() >= $this->max_attendees;
    }

    public function getRemainingSeatsAttribute(): ?int
    {
        if (is_null($this->max_attendees)) {
            return null;
        }
        return max(0, $this->max_attendees - $this->registrations()->count());
    }
}
