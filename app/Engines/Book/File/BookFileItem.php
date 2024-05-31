<?php

namespace App\Engines\Book\File;

use App\Enums\BookFormatEnum;
use App\Models\Library;
use Kiwilan\LaravelNotifier\Facades\Journal;

class BookFileItem
{
    protected function __construct(
        protected string $basename,
        protected BookFormatEnum $format,
        protected Library $library,
        protected string $path,
        protected string $filename,
        protected string $extension,
        protected ?string $mimeType = null,
        protected int $size = 0,
        protected bool $isAudio = false,
    ) {
    }

    public static function make(BookFormatEnum $format, Library $library, string $path): ?self
    {
        if (! file_exists($path)) {
            Journal::error("File not found: {$path}");

            return null;
        }

        $self = new self(
            basename: pathinfo($path, PATHINFO_BASENAME),
            format: $format,
            library: $library,
            path: $path,
            filename: pathinfo($path, PATHINFO_FILENAME),
            extension: pathinfo($path, PATHINFO_EXTENSION),
            mimeType: mime_content_type($path),
            size: filesize($path),
        );

        if ($format === BookFormatEnum::audio) {
            $self->isAudio = true;
        }

        return $self;
    }

    public static function fromArray(array $array, Library $library): self
    {
        $format = BookFormatEnum::tryFrom($array['format']);
        $self = BookFileItem::make($format, $library, $array['path']);

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

    public function library(): Library
    {
        return $this->library;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function filename(): string
    {
        return $this->filename;
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

    public function isAudio(): bool
    {
        return $this->isAudio;
    }

    public function toArray(): array
    {
        return [
            'basename' => $this->basename,
            'format' => $this->format,
            'library' => $this->library,
            'path' => $this->path,
        ];
    }
}
