<?php

namespace App\Engines\Book\File;

use App\Enums\BookFormatEnum;
use DateTime;
use Kiwilan\LaravelNotifier\Facades\Journal;

class BookFileItem
{
    protected function __construct(
        protected string $basename,
        protected string $libraryId,
        protected string $path,
        protected string $extension,
        protected ?string $mimeType = null,
        protected int $size = 0,
        protected ?DateTime $dateAdded = null,
    ) {
    }

    public static function make(string $path, string $libraryId): ?self
    {
        /** @var ?string $extension */
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if (! array_key_exists(strtolower($extension), BookFormatEnum::ALLOWED_EXTENSIONS)) {
            Journal::warning("BookFileItem: extension not accepted {$path}");

            return null;
        }

        if ($extension === null || $extension === '') {
            Journal::warning("BookFileItem: extension not valid {$path}");

            return null;
        }

        if (! file_exists($path)) {
            Journal::error("BookFileItem: file not found {$path}");

            return null;
        }

        $self = new self(
            basename: pathinfo($path, PATHINFO_BASENAME),
            libraryId: $libraryId,
            path: $path,
            extension: pathinfo($path, PATHINFO_EXTENSION),
            // mimeType: mime_content_type($path),
            size: filesize($path),
            dateAdded: filemtime($path) ? new DateTime('@'.filemtime($path)) : null,
        );

        return $self;
    }

    public function basename(): string
    {
        return $this->basename;
    }

    public function libraryId(): string
    {
        return $this->libraryId;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function extension(): string
    {
        return $this->extension;
    }

    public function mimeType(): ?string
    {
        return $this->mimeType;
    }

    public function size(): int
    {
        return $this->size;
    }

    public function dateAdded(): ?DateTime
    {
        return $this->dateAdded;
    }

    public function toArray(): array
    {
        return [
            'basename' => $this->basename,
            'libraryId' => $this->libraryId,
            'path' => $this->path,
            'extension' => $this->extension,
            'mimeType' => $this->mimeType,
            'size' => $this->size,
        ];
    }
}
