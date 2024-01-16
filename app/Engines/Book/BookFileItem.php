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
}
