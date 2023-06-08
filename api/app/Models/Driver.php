<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_make',
        'vehicle_model',
        'vehicle_license_plate',
        'avatar',
        'licence',
        'national_identity',
        'status'
    ];

    public function users() {
        return $this->belongsTo( User::class );
    }

    public function rides() {
        return $this->hasMany( Trip::class );
    }

    public function ratings() {
        return $this->hasMany( Rating::class );
    }
}
