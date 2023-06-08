<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DriverSeeder extends Seeder {
    public function run() {
        $faker = Faker::create();

        $minLat = -6.977894;
        $maxLat = -6.668553;
        $minLng = 39.170757;
        $maxLng = 39.431641;

        for ( $i = 1; $i <= 20; $i++ ) {
            DB::table( 'drivers' )->insert( [
                'user_id' => $faker->numberBetween( 1, 10 ),
                'vehicle_make' => $faker->randomElement( [ 'Sedan', 'SUV', 'Truck', 'Motorcycle' ] ),
                'vehicle_model' => $faker->company,
                'latitude'=>mt_rand( $minLat * 1000000, $maxLat * 1000000 ) / 1000000,
                'longitude'=> mt_rand( $minLng * 1000000, $maxLng * 1000000 ) / 1000000,
                'status' => $faker->randomElement( [ 'online', 'offline' ] ),
                'vehicle_license_plate' => $faker->bothify( '???-####' ),
                'avatar'=> NULL,
                'licence'=>NULL,
                'national_identity'=>NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ] );
        }
    }
}
