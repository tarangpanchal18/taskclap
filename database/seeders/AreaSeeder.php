<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = [
            'Ghodasar',
            'Isanpur',
            'Maninagar',
            'Vastral',
            'Nikol',
            'Narol',
            'Vatwa',
        ];

        foreach ($areas as $area) {
            DB::table('areas')->insert([
                'name' => $area,
                'city_id' => 1,
                'state_id' => 1,
                'country_id' => 1,
                'created_at' => '2016-05-12 11:25:00',
                'updated_at' => '2016-05-12 11:25:00',
            ]);
        }
    }
}
