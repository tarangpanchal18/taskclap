<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryStateCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            'name' => 'India',
            'phonecode' => '91',
            'currency' => 'INR',
            'currency_symbol' => '₹',
            'timezones' => '+05:30',
            'created_at' => '2016-05-12 11:25:00',
            'updated_at' => '2016-05-12 11:25:00',
        ]);

        DB::table('states')->insert([
            'name' => 'Gujarat',
            'country_id' => 1,
            'created_at' => '2016-05-12 11:25:00',
            'updated_at' => '2016-05-12 11:25:00',
        ]);

        DB::table('cities')->insert([
            'name' => 'Ahmedabad',
            'state_id' => 1,
            'country_id' => 1,
            'created_at' => '2016-05-12 11:25:00',
            'updated_at' => '2016-05-12 11:25:00',
        ]);
    }
}
