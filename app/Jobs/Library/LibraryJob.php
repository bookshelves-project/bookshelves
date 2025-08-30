<?php

namespace App\Jobs\Library;

use App\Engines\Library\FileItem;
use App\Engines\Library\LibraryScanner;
use App\Facades\Bookshelves;
use App\Models\File;
use App\Models\Library;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Kiwilan\LaravelNotifier\Facades\Journal;

class LibraryJob implements ShouldQueue
{
    use Batchable, Queueable;

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
        Journal::info("LibraryScanJob: Scanning library: {$this->library->name}...");

        if ($this->fresh) {
            Journal::info('LibraryScanJob: Fresh install!');
        }

        $this->handleFiles();
        $this->handleLibrary();
    }

    /**
     * Handle file processing.
     */
    private function handleFiles(): void
    {
        Journal::info('LibraryScanJob: Convert files to `FileItem`...');
        $file_items = $this->scanner->convertToFileItems();
        if (empty($file_items)) {
            Journal::warning("LibraryScanJob: No files found in library: {$this->library->name}");

            return;
        }

        if ($this->fresh) {
            $count = count($file_items);
            Journal::info("LibraryScanJob: fresh parsing for {$count} files...");
            // $this->dispatchBookJob($file_items);
            // foreach ($file_items as $i => $file_item) {
            //     BookIndexJob::dispatch($file_item, $this->library->id, "{$i}/{$count}");
            // }

            return;
        }

        $index_count = $this->scanner->getCount();
        $db_count = File::query()
            ->where('library_id', $this->library->id)
            ->count();

        if ($index_count === $db_count) {
            Journal::info('LibraryScanJob: already up to date.');

            return;
        }

        Journal::info('LibraryScanJob: standard parsing...');
        $this->parseStandard();
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

    /**
     * Standard parse for files (parse only new files and remove deleted files).
     */
    private function parseStandard(): void
    {
        $files = File::query()
            ->where('library_id', $this->library->id)
            ->get()
            ->map(fn (File $file) => $file->path)
            ->toArray();

        $new_files = $this->findNewFiles($this->scanner->getFilePaths(), $files);
        $lost_files = $this->findLostFiles($this->scanner->getFilePaths(), $files);
        $this->removeFiles($lost_files, $this->library->name);

        if (Bookshelves::verbose()) {
            $count_new_files = count($new_files);
            $count_lost_files = count($lost_files);
            Journal::debug("LibraryScanJob: found {$count_new_files} new files to add.");
            Journal::debug("LibraryScanJob: found {$count_lost_files} lost files to remove.");
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        $file_items = [];
        foreach ($new_files as $path) {
            $file = FileItem::make($path, $this->library->id, $finfo);
            if (! $file) {
                continue;
            }

            $file_items[] = $file;
        }

        finfo_close($finfo);
        // $this->dispatchBookJob($file_items);
    }

    /**
     * Find new files to parse.
     *
     * @param  string[]  $paths
     * @param  string[]  $files
     * @return string[]
     */
    private function findNewFiles(array $paths, array $files): array
    {
        $paths = array_filter($paths, function (string $path) use ($files) {
            if (! in_array($path, $files, true)) {
                return true;
            }

            return false;
        });

        return array_values($paths);
    }

    /**
     * Find lost files to remove.
     *
     * @param  string[]  $paths
     * @param  string[]  $files
     * @return string[]
     */
    private function findLostFiles(array $paths, array $files): array
    {
        $files = array_filter($files, function (string $file) use ($paths) {
            if (! in_array($file, $paths, true)) {
                return true;
            }

            return false;
        });

        return array_values($files);
    }

    /**
     * Delete files.
     *
     * @param  string[]  $lost_files  Lost files paths.
     */
    private function removeFiles(array $lost_files, string $library_name): void
    {
        $files = File::query()
            ->whereIn('path', $lost_files)
            ->get();

        Journal::info("BooksDispatchJob: delete {$files->count()} files for {$library_name}...", [
            'files' => $files->pluck('path')->toArray(),
        ]);

        foreach ($files as $file) {
            $file->delete();
        }
    }
}
