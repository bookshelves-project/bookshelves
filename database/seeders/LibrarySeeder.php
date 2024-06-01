<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Kiwilan\LaravelNotifier\Facades\Journal;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::seed();
    }

    public static function seed(): void
    {
        $json = base_path('libraries.json');
        if (file_exists($json)) {
            Journal::info('LibrarySeeder: `./libraries.json` found');
        } else {
            Journal::info('LibrarySeeder: `./libraries.json` not found');

            return;
        }

        $libraries = json_decode(file_get_contents($json), true);
        foreach ($libraries as $library) {
            \App\Models\Library::query()->create($library);
        }
    }
}
