<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
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
        $categories = [
            'Fantasy',
            'Science-fiction',
            'Historic',
        ];

        foreach ($categories as $key => $value) {
            Category::create([
                'name' => $value,
                'slug' => Str::slug($value),
            ]);
        }
    }
}
