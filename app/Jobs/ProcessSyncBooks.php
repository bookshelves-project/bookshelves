<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class ProcessSyncBooks implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $timeout = 86400;
    public $failOnTimeout = true;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public bool $fresh = false,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('SyncBooksProcess: start');

        Log::debug('SyncBooksProcess: generate');
        Artisan::call('bookshelves:generate', [
            '--fresh' => $this->fresh,
            '--force' => true,
        ]);

        Log::debug('SyncBooksProcess: api');
        Artisan::call('bookshelves:api', [
            '--books' => true,
            '--authors' => true,
            '--series' => true,
            '--fresh' => $this->fresh,
            '--force' => true,
        ]);

        Log::info('SyncBooksProcess: end');
    }
}
