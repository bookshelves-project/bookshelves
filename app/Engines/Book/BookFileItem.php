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
    ) {
    }

    public static function make(BookFormatEnum $format, BookTypeEnum $type, string $path): self
    {
        $basename = pathinfo($path, PATHINFO_BASENAME);

        return new self($basename, $format, $type, $path);
    }

    public static function fromArray(array $array): self
    {
        $format = BookFormatEnum::tryFrom($array['format']);
        $type = BookTypeEnum::tryFrom($array['type']);

        return new self($array['basename'], $format, $type, $array['path']);
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
