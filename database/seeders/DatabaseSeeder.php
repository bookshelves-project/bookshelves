<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Jobs\Clean\CleanCoversJob;
use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Console\OptimizeClearCommand;
use Illuminate\Support\Facades\Artisan;
use Kiwilan\Steward\Commands\Log\LogClearCommand;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        CleanCoversJob::dispatch();

        Artisan::call(LogClearCommand::class, ['--all' => true]);
        Artisan::call(OptimizeClearCommand::class);

        Book::removeAllFromSearch();
        Author::removeAllFromSearch();
        Serie::removeAllFromSearch();

        $this->call([
            EmptySeeder::class,
            LibrarySeeder::class,
        ]);
    }
}
