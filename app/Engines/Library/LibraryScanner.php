<?php

namespace App\Engines\Library;

use App\Engines\BookshelvesUtils;
use App\Enums\BookFormatEnum;
use App\Facades\Bookshelves;
use App\Models\Library;
use Carbon\Carbon;
use DateTime;
use Kiwilan\FileList\FileList;
use Kiwilan\LaravelNotifier\Facades\Journal;

/**
 * Scan a library to find all book files.
 *
 * - Can convert file paths to `FileItem` objects.
 * - Can serialize the index to a file.
 */
class LibraryScanner
{
    /** @var string[] */
    protected array $file_paths = [];

    /**
     * @var string[]
     */
    protected array $skip_extensions = [];

    protected function __construct(
        protected Library $library,
        protected string $library_path,
        protected bool $is_valid = false,
        protected ?Carbon $scanned_at = null,
        protected ?Carbon $modified_at = null,
        protected int $count = 0,
    ) {}

    /**
     * Execute the library scanner.
     *
     * @param  Library  $library  The library to scan.
     * @param  string[]  $skip_extensions  File extensions to skip, default is `[]`.
     * @param  int|null  $limit  Limit the number of files to scan, default is `null` (no limit).
     */
    public static function make(
        Library $library,
        ?int $limit = null,
        array $skip_extensions = [],
    ): ?self {
        $path = $library->path;
        $self = new self($library, $path, $library->path_is_valid);
        $self->skip_extensions = $skip_extensions;
        $self->modified_at = new Carbon('@'.filemtime($path), config('app.timezone'));

        if (! $self->is_valid) {
            return $self;
        }

        $self->file_paths = array_values($self->scan($limit));
        $self->count = count($self->file_paths);
        $self->scanned_at = new Carbon('now', timezone: config('app.timezone'));

        return $self;
    }

    /**
     * Get the library path.
     */
    public function getLibraryPath(): string
    {
        return $this->library_path;
    }

    /**
     * Check if the library path is valid.
     */
    public function isValid(): bool
    {
        return $this->is_valid;
    }

    /**
     * Get scanned date.
     */
    public function getScannedAt(): ?DateTime
    {
        return $this->scanned_at;
    }

    /**
     * Get the last modified date.
     */
    public function getModifiedAt(): ?Carbon
    {
        return $this->modified_at;
    }

    /**
     * Get all file paths as array of strings.
     *
     * @return string[]
     */
    public function getFilePaths(): array
    {
        return $this->file_paths;
    }

    /**
     * Get the number of files found.
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * Get an array of skipped file extensions.
     *
     * @return string[]
     */
    public function getSkipExtensions(): array
    {
        return $this->skip_extensions;
    }

    /**
     * Scan the library directory for files.
     *
     * @return string[]
     */
    private function scan(?int $limit = null): array
    {
        $engine = Bookshelves::analyzerEngine();

        if ($this->is_valid) {
            Journal::info("LibraryScanner: {$this->library->name} scanning: {$this->library->path} (engine: {$engine})");
        } else {
            Journal::warning("LibraryScanner: {$this->library->name} path not found: {$this->library->path}");

            return [];
        }

        $browser = FileList::make($this->library->path)
            ->onlyExtensions(BookFormatEnum::ALLOWED_EXTENSIONS)
            ->skipExtensions($this->skip_extensions);

        if ($limit) {
            $browser->limit($limit);
        }

        if ($engine === 'scout-seeker') {
            $browser->withScoutSeeker();
        }

        $browser->run();

        if ($browser->getCommand()) {
            $name = $browser->getCommand()->getName();
            $command = $browser->getCommand()->getCommand();
            $user = $browser->getCommand()->getUser();
            if (Bookshelves::verbose()) {
                Journal::debug("LibraryScanner: {$this->library->name} `{$name}` command: `{$command}` by `{$user}`");
            }
        }

        if (Bookshelves::verbose()) {
            Journal::debug("LibraryScanner: {$this->library->name} time elapsed: {$browser->getTimeElapsed()}");
        }

        return $browser->getFiles();
    }

    /**
     * Convert the scanned paths to `FileItem` array.
     *
     * @return FileItem[]
     */
    public function convertToFileItems(): array
    {
        $items = [];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        foreach ($this->file_paths as $file_path) {
            $book_file = FileItem::make($file_path, $this->library->id, $finfo);
            if ($book_file) {
                $items[] = $book_file;
            }
        }

        finfo_close($finfo);

        return $items;
    }

    /**
     * Serialize the index to a file.
     */
    public function serialize(?string $path = null): bool
    {
        $path = $path ?? $this->library->getIndexLibraryPath();

        if (! $this->is_valid) {
            Journal::error("LibraryScanner: {$this->library->name} path not valid: {$path}");

            return false;
        }

        $data = [
            'library_id' => $this->library->id,
            'scanned_at' => $this->scanned_at?->format('Y-m-d H:i:s'),
            'modified_at' => $this->modified_at,
            'file_paths' => $this->file_paths,
            'count' => $this->count,
        ];

        return BookshelvesUtils::serialize($path, $data);
    }
}
