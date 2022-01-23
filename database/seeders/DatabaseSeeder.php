<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        Storage::disk('public')->deleteDirectory('media');

        $this->call(UserSeeder::class);
        $this->call(PostSeeder::class);
    }
}
