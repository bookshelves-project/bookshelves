<?php

namespace App\Engines\Library;

use App\Enums\BookFormatEnum;
use DateTime;
use Kiwilan\LaravelNotifier\Facades\Journal;

/**
 * Represents a file item in the library.
 */
class FileItem
{
    protected function __construct(
        protected string $basename,
        protected string $library_id,
        protected string $path,
        protected string $extension,
        protected ?string $mime_type = null,
        protected int $size = 0,
        protected ?DateTime $date_added = null,
    ) {}

    /**
     * Create a new `FileItem` instance from a file path.
     */
    public static function make(string $path, string|int $library_id, \finfo|false|null $finfo = null): ?self
    {
        /** @var ?string $extension */
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if (! in_array(strtolower($extension), BookFormatEnum::ALLOWED_EXTENSIONS)) {
            Journal::warning("FileItem: extension not accepted {$extension} from {$path}");

            return null;
        }

        if ($extension === null || $extension === '') {
            Journal::warning("FileItem: extension not valid {$extension} from {$path}");

            return null;
        }

        if (! file_exists($path)) {
            Journal::error("FileItem: file not found {$path}");

            return null;
        }

        $self = new self(
            basename: pathinfo($path, PATHINFO_BASENAME),
            library_id: $library_id,
            path: $path,
            extension: pathinfo($path, PATHINFO_EXTENSION),
            mime_type: $finfo ? finfo_file($finfo, $path) : null,
            size: filesize($path),
            date_added: filemtime($path) ? new DateTime('@'.filemtime($path)) : null,
        );

        return $self;
    }

    /**
     * Get the file basename.
     *
     * e.g. `batman___knightfall-3-batman___knightfall,_tome_3-fra.cbz`
     */
    public function getBasename(): string
    {
        return $this->basename;
    }

    /**
     * Get the library ID.
     */
    public function getLibraryID(): string
    {
        return $this->library_id;
    }

    /**
     * Get the file path.
     *
     * e.g. `/books/ebooks/anna_gavalda/--ensemble,_c'est_tout-fra.epub`
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get the file extension.
     *
     * e.g. `epub`
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * Get the MIME type of the file.
     *
     * e.g. `application/epub+zip`
     */
    public function getMimeType(): ?string
    {
        return $this->mime_type;
    }

    /**
     * Get the file size in bytes.
     *
     * e.g. `790406`
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Get the human-readable file size.
     *
     * @param  int  $dec  Define the number of decimal places.
     *
     * e.g. `922,80 kB`
     */
    public function getSizeHuman(int $dec = 2): string
    {
        $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $factor = floor((strlen(strval($this->size)) - 1) / 3);
        if ($factor == 0) {
            $dec = 0;
        }

        return sprintf("%.{$dec}f %s", $this->size / (1024 ** $factor), $size[$factor]);
    }

    /**
     * Get the date the file was added.
     */
    public function getDateAdded(): ?DateTime
    {
        return $this->date_added;
    }

    /**
     * Convert the file item to an array.
     */
    public function toArray(): array
    {
        return [
            'basename' => $this->basename,
            'library_id' => $this->library_id,
            'path' => $this->path,
            'extension' => $this->extension,
            'mime_type' => $this->mime_type,
            'size' => $this->size,
            'date_added' => $this->date_added,
        ];
    }
}
