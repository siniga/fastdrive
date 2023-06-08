<?php

namespace Database\Seeders;

use App\Models\Ride;
use Illuminate\Database\Seeder;
use App\Models\Rating;
use App\Models\User;
use App\Models\Driver;
use App\Models\Trip;

class RatingSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('email', 'johndoe@example.com')->first();
        $driver = Driver::first();
        $trip = Ride::first();

        Rating::create([
            'user_id' => $user->id,
            'driver_id' => $driver->id,
            'ride_id' => $trip->id,
            'rating' => 5,
            'comment' => 'Great driver!',
        ]);
    }
}
