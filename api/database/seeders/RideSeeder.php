<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Driver;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RideSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $users = User::all();
        $drivers = Driver::all();

        for ($i = 1; $i <= 20; $i++) {
            $user = $users->random();
            $driver = $drivers->random();

            DB::table('rides')->insert([
                'user_id' => $user->id,
                'driver_id' => $driver->id,
                'pickup_address' => $faker->address,
                'dropoff_address' => $faker->address,
                'pickup_latitude' => $faker->latitude(-90, 90),
                'pickup_longitude' => $faker->longitude(-180, 180),
                'dropoff_latitude' => $faker->latitude(-90, 90),
                'dropoff_longitude' => $faker->longitude(-180, 180),
                'status' => $faker->randomElement(['requested', 'accepted', 'started', 'completed', 'cancelled']),
                'price' => $faker->numberBetween(1000, 1000000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
