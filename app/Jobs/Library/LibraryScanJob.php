<?php

namespace App\Jobs\Library;

use App\Engines\BookshelvesUtils;
use App\Engines\Converter\BookConverter;
use App\Engines\Library\FileItem;
use App\Engines\Library\LibraryScanner;
use App\Facades\Bookshelves;
use App\Models\File;
use App\Models\Library;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Kiwilan\Ebook\Ebook;
use Kiwilan\LaravelNotifier\Facades\Journal;

/**
 * Job to scan a library and create files.
 *
 * @param  string  $library_slug
 * @param  int|null  $limit  Limit the number of files to process
 * @param  bool  $fresh  To delete all files and re-create them, if `false`, only create new files
 *
 * With standard parser, if Library hasn't new files, it will be skipped.
 */
class LibraryScanJob implements ShouldQueue
{
    use Queueable;

    private Library $library;

    private LibraryScanner $scanner;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private string $library_slug,
        private ?int $limit = null,
        private bool $fresh = false,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->library = Library::where('slug', $this->library_slug)->firstOrFail();
        $this->scanner = LibraryScanner::make($this->library, $this->limit);
        Journal::info("LibraryScanJob: Scanning library: {$this->library->name}...");

        if ($this->fresh) {
            Journal::info('LibraryScanJob: Fresh install!');
        }

        $this->handleFiles();
        $this->handleLibrary();
    }

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

    private function handleFiles(): void
    {
        $file_items = $this->scanner->convertToFileItems();
        if (empty($file_items)) {
            Journal::warning("LibraryScanJob: No files found in library: {$this->library->name}");

            return;
        }

        if ($this->fresh) {
            $count = count($file_items);
            Journal::info("LibraryScanJob: fresh parsing for {$count} files...");
            $this->parseFresh($file_items);

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
        $this->dispatchBookJob($file_items);
    }

    /**
     * Fresh parse for files (delete all and re-create).
     */
    private function parseFresh(array $file_items): void
    {
        $this->dispatchBookJob($file_items);
    }

    private function dispatchBookJob(array $file_items): void
    {
        $i = 0;
        $count = count($file_items);
        $files = [];

        foreach ($file_items as $file_item) {
            $i++;
            $file = $this->convertFileItem($file_item);
            $files[] = $file;
            $this->handleBookJob("{$i}/{$count}", $file);
        }

        foreach ($files as $i => $file) {
            /** @var Ebook $ebook */
            $ebook = BookshelvesUtils::unserialize($file->getBookIndexPath());
            if (Bookshelves::verbose()) {
                Journal::debug("BookJob: {$i}/{$count} {$file->basename} from {$this->library->name}");
            }
            BookConverter::make($ebook, $file);
        }
    }

    private function handleBookJob(string $number, File $file): void
    {
        if (Bookshelves::verbose()) {
            Journal::debug("BookJob: {$number} {$file->basename} from {$this->library->name}");
        }

        try {
            $ebook = Ebook::read($file->path);
            $ebook->getPagesCount();
        } catch (\Throwable $th) {
            Journal::error("XML error on {$file->path}", [$th->getMessage()]);

            return;
        }

        $index_path = $file->getBookIndexPath();
        BookshelvesUtils::serialize($index_path, $ebook);

        if (! $ebook) {
            Journal::warning("BookJob: {$number} no ebook detected at {$file->path}", [
                'ebook' => $ebook,
            ]);

            return;
        }
    }

    private function convertFileItem(FileItem $file_item): File
    {
        return File::create([
            'path' => $file_item->getPath(),
            'basename' => $file_item->getBasename(),
            'extension' => $file_item->getExtension(),
            'mime_type' => $file_item->getMimeType(),
            'size' => $file_item->getSize(),
            'date_added' => $file_item->getDateAdded(),
            'library_id' => $this->library->id,
        ]);
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
