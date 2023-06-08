<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        $dar_es_salaam_latitude = -6.7924;
        $dar_es_salaam_longitude = 39.2083;
        
        for ($i = 1; $i <= 2; $i++) {
            DB::table('user_locations')->insert([
                'user_id' => $faker->numberBetween(1, 10),
                'latitude' => $faker->latitude($dar_es_salaam_latitude - 0.05, $dar_es_salaam_latitude + 0.05),
                'longitude' => $faker->longitude($dar_es_salaam_longitude - 0.05, $dar_es_salaam_longitude + 0.05),
                'name' => $faker->name,
                'status' => 'Home'
                
            ]);
        }
        
    }
}
