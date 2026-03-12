<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RidePassenger extends Model
{
    protected $fillable = [
        'ride_id',
        'registration_id',
        'assignment_reason',
    ];

    public function ride(): BelongsTo
    {
        return $this->belongsTo(Ride::class);
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
}
