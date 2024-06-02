<?php

namespace App\Engines\Book\File;

use App\Enums\BookFormatEnum;
use DateTime;
use Kiwilan\LaravelNotifier\Facades\Journal;

class BookFileItem
{
    protected function __construct(
        protected string $basename,
        protected BookFormatEnum $format,
        protected string $libraryId,
        protected string $path,
        protected string $extension,
        protected ?string $mimeType = null,
        protected int $size = 0,
        protected ?DateTime $dateAdded = null,
        protected bool $isAudio = false,
    ) {
    }

    public static function make(string $path, string $libraryId): ?self
    {
        /** @var ?string $extension */
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if ($extension === null || $extension === '') {
            Journal::debug("BookFileItem: extension not found: {$path}");

            return null;
        }

        $format = BookFormatEnum::fromExtension($extension);

        if (! array_key_exists($format->value, BookFormatEnum::toArray())) {
            Journal::debug("BookFileItem: format not found: {$path}");

            return null;
        }

        if ($format->value === BookFormatEnum::unknown->value) {
            Journal::debug("BookFileItem: unknown format: {$path}");

            return null;
        }

        if (! file_exists($path)) {
            Journal::error("BookFileItem: file not found: {$path}");

            return null;
        }

        $self = new self(
            basename: pathinfo($path, PATHINFO_BASENAME),
            format: $format,
            libraryId: $libraryId,
            path: $path,
            extension: pathinfo($path, PATHINFO_EXTENSION),
            // mimeType: mime_content_type($path),
            size: filesize($path),
            dateAdded: filemtime($path) ? new DateTime('@'.filemtime($path)) : null,
        );

        if ($format === BookFormatEnum::audio) {
            $self->isAudio = true;
        }

        return $self;
    }

    public function basename(): string
    {
        return $this->basename;
    }

    public function format(): BookFormatEnum
    {
        return $this->format;
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

    public function isAudio(): bool
    {
        return $this->isAudio;
    }

    public function toArray(): array
    {
        return [
            'basename' => $this->basename,
            'format' => $this->format,
            'libraryId' => $this->libraryId,
            'path' => $this->path,
            'extension' => $this->extension,
            'mimeType' => $this->mimeType,
            'size' => $this->size,
            'isAudio' => $this->isAudio,
        ];
    }
}
