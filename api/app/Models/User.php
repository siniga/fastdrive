<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name', 'email', 'password','phone_number','otp','otp_expires_at','is_registered',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function routeNotificationForSms()
    {
        return $this->phone_number;
    }

    public function rides()
    {
        return $this->hasMany(Ride::class);
    }


    public function user_locations()
    {
        return $this->hasMany(UserLocation::class);
    }

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function drivers()
    {
        return $this->hasOne(Driver::class);
    }
}
