<?php

namespace App\Jobs;

use App\Console\Commands\Bookshelves\AudiobooksCommand;
use App\Console\Commands\Bookshelves\AuthorsCommand;
use App\Console\Commands\Bookshelves\CleanCommand;
use App\Console\Commands\Bookshelves\GoogleBooksCommand;
use App\Console\Commands\Bookshelves\SeriesCommand;
use App\Facades\Bookshelves;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class ExtrasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Artisan::call(AudiobooksCommand::class);
        Artisan::call(AuthorsCommand::class);
        Artisan::call(SeriesCommand::class);
        if (Bookshelves::apiGoogleBooks()) {
            Artisan::call(GoogleBooksCommand::class);
        }
        Artisan::call(CleanCommand::class);
        ScoutWrapperJob::dispatch();
    }
}
