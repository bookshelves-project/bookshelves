<?php

namespace App\Engines\Book;

use App\Enums\BookFormatEnum;
use App\Models\Library;

class BookFileItem
{
    protected function __construct(
        protected string $basename,
        protected BookFormatEnum $format,
        protected Library $library,
        protected ?string $path,
        protected bool $isAudio = false,
    ) {
    }

    public static function make(BookFormatEnum $format, Library $library, string $path): self
    {
        $basename = pathinfo($path, PATHINFO_BASENAME);
        $self = new self($basename, $format, $library, $path);

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
