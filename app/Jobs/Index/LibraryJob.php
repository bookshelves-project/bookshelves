<?php

namespace App\Jobs\Index;

use App\Engines\BookshelvesUpdater;
use App\Engines\Library\LibraryScanner;
use App\Models\Library;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Kiwilan\LaravelNotifier\Facades\Journal;

class LibraryJob implements ShouldQueue
{
    use Batchable, Dispatchable, Queueable;

    private Library $library;

    private LibraryScanner $scanner;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected int|string $library_id,
        protected ?int $limit = null,
        protected bool $fresh = false,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->library = Library::find($this->library_id);
        $this->scanner = LibraryScanner::make($this->library, $this->limit);
        $this->scanner->serialize();

        Journal::info("LibraryScanJob: Scanning library: {$this->library->name}...");

        if ($this->fresh) {
            Journal::info('LibraryScanJob: Fresh install!');
        }

        $this->handleLibrary();
        BookshelvesUpdater::make($this->library, $this->scanner->getFilePaths(), $this->fresh);
    }

    /**
     * Handle library metadata updates.
     */
    private function handleLibrary(): void
    {
        if ($this->scanner->getScannedAt() && $this->scanner->getModifiedAt()) {
            $this->library->library_scanned_at = new Carbon($this->scanner->getScannedAt());
            $this->library->library_modified_at = new Carbon($this->scanner->getModifiedAt());
            $this->library->save();
        } else {
            throw new \Exception("LibraryScanJob: Failed to retrieve scan dates for library: {$this->library->name}");
        }
    }
}
