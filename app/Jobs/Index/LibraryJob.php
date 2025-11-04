<?php

namespace App\Jobs\Index;

use App\Engines\Library\LibraryScanner;
use App\Engines\Updater;
use App\Models\Library;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Kiwilan\LaravelNotifier\Facades\Journal;

class LibraryJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private LibraryScanner $scanner;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Library $library,
        protected bool $fresh = false,
        protected ?int $limit = null,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->scanner = LibraryScanner::make($this->library, $this->limit);
        if (! $this->scanner) {
            Journal::warning("LibraryJob: Skip {$this->library->name} because scanner fails.");
        }

        $this->scanner->serialize();

        Journal::info("LibraryScanJob: Scanning library: {$this->library->name}...");

        if ($this->fresh) {
            Journal::info('LibraryScanJob: Fresh install!');
        }

        $this->handleLibrary();
        Updater::make($this->library, $this->scanner->getFilePaths(), $this->fresh);
    }

    /**
     * Handle library metadata updates.
     */
    private function handleLibrary(): void
    {
        if ($this->scanner->getScannedAt() && $this->scanner->getModifiedAt()) {
            $this->library->library_scanned_at = new Carbon($this->scanner->getScannedAt());
            $this->library->library_modified_at = new Carbon($this->scanner->getModifiedAt());
            $this->library->saveQuietly();
        } else {
            throw new \Exception("LibraryScanJob: Failed to retrieve scan dates for library: {$this->library->name}");
        }
    }
}
