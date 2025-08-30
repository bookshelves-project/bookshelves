<?php

namespace App\Jobs\Library;

use App\Models\Library;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Kiwilan\LaravelNotifier\Facades\Journal;

class LibraryScanningJob implements ShouldQueue
{
    use Batchable, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private string $library_slug,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $library = Library::where('slug', $this->library_slug)->firstOrFail();
        Journal::info("LibraryScanJob: Scanning library: {$library->name}...");
    }
}
