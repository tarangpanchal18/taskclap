<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Service',
            'Repair',
            'Install',
            'Uninstallation',
            'Install / Uninstallation',
            'Bestseller',
        ];

        foreach ($categories as $category) {
            ServiceCategory::create([
                'name' => $category,
                'description' => $category . ' Service at affordable price.',
                'status' => 'Active',
            ]);
        }
    }
}
