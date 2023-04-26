<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory(1)->create([
            'parent_id' => Category::factory([
                'parent_id' => null
            ])->create()->id
        ]);
    }
}
