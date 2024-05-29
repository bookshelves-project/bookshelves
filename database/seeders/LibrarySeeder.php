<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
        $data = database_path('seeders/data');
        if (config('app.env') === 'local') {
            $data = "{$data}/libraries-local.json";
        } else {
            $data = "{$data}/libraries.json";
        }

        $libraries = json_decode(file_get_contents($data), true);

        foreach ($libraries as $library) {
            if (config('app.env') === 'production') {
                $library['path'] = str_replace('/Volumes/library/', '/mnt/cloud_unicorn_library/', $library['path']);
            }
            \App\Models\Library::query()->create($library);
        }
    }
}
