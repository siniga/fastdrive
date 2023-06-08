<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'driver_id', 'pickup_address', 'dropoff_address',
        'pickup_latitude', 'pickup_longitude', 'dropoff_latitude',
        'dropoff_longitude', 'status',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function drivers()
    {
        return $this->belongsTo(Driver::class);
    }

    public function ratings()
    {
        return $this->hasOne(Rating::class);
    }
}
