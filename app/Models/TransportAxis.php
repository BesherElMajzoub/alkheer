<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransportAxis extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function areas(): HasMany
    {
        return $this->hasMany(Area::class);
    }

    public function rides(): HasMany
    {
        return $this->hasMany(Ride::class);
    }

    /**
     * Axes that THIS axis can serve as fallback for.
     */
    public function neighbors()
    {
        return $this->belongsToMany(
            TransportAxis::class,
            'axis_neighbors',
            'axis_id',
            'neighbor_axis_id'
        )->withPivot('priority')->orderByPivot('priority');
    }

    /**
     * Axes that consider THIS axis as a neighbor.
     */
    public function neighborOf()
    {
        return $this->belongsToMany(
            TransportAxis::class,
            'axis_neighbors',
            'neighbor_axis_id',
            'axis_id'
        )->withPivot('priority');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
