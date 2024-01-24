<?php

namespace App\Engines\Book;

use App\Enums\BookFormatEnum;
use App\Enums\BookTypeEnum;

class BookFileItem
{
    protected function __construct(
        protected ?string $basename,
        protected ?BookFormatEnum $format,
        protected ?BookTypeEnum $type,
        protected ?string $path,
        protected bool $isAudio = false,
    ) {
    }

    public static function make(BookFormatEnum $format, BookTypeEnum $type, string $path): self
    {
        $basename = pathinfo($path, PATHINFO_BASENAME);
        $self = new self($basename, $format, $type, $path);

        if ($format === BookFormatEnum::audio) {
            $self->isAudio = true;
        }

        return $self;
    }

    public static function fromArray(array $array): self
    {
        $format = BookFormatEnum::tryFrom($array['format']);
        $type = BookTypeEnum::tryFrom($array['type']);
        $self = BookFileItem::make($format, $type, $array['path']);

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

    public function type(): BookTypeEnum
    {
        return $this->type;
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
            'format' => $this->format->value,
            'type' => $this->type->value,
            'path' => $this->path,
        ];
    }
}
