<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pagesList = [
            'Privacy Policy',
            'Terms & Condition',
            'Cookies Policy',
        ];

        foreach ($pagesList as $page) {
            Page::create([
                'slug' => \Str::slug($page),
                'title' => $page,
                'description' => $page,
                'seo_description' => $page,
                'seo_keywords' => $page,
                'status' => 'Active',
            ]);
        }
    }
}
