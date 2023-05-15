<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(50)->create([
            'country_id' => 1,
            'state_id' => 1,
            'city_id' => 1,
            'area_id' => 1,
            'address_lat' => '22.9755',
            'address_long' => '72.6155',
        ]);
    }
}
