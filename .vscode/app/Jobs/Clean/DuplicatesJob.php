<?php

namespace App\Jobs\Clean;

use App\Console\Commands\Bookshelves\Duplicates\DuplicatesCommand;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Kiwilan\LaravelNotifier\Facades\Journal;

class DuplicatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Journal::info('DuplicatesJob: duplicates cleanup job.');

        Artisan::call(DuplicatesCommand::class, [
            '--clean' => true,
        ]);
    }
}
