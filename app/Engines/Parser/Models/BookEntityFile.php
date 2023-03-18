<?php

namespace App\Engines\Parser\Models;

use App\Engines\Parser\Parsers\BookFile;
use App\Enums\BookFormatEnum;
use App\Enums\BookTypeEnum;

class BookEntityFile
{
    protected function __construct(
        protected ?string $name = null,
        protected ?string $filename = null,
        protected ?string $path = null,
        protected ?string $extension = null,
        protected ?BookTypeEnum $type = null,
        protected ?BookFormatEnum $format = null,
    ) {
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function filename(): ?string
    {
        return $this->filename;
    }

    public function path(): ?string
    {
        return $this->path;
    }

    public function extension(): ?string
    {
        return $this->extension;
    }

    public function type(): ?BookTypeEnum
    {
        return $this->type;
    }

    public function format(): ?BookFormatEnum
    {
        return $this->format;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'filename' => $this->filename,
            'path' => $this->path,
            'extension' => $this->extension,
            'type' => $this->type,
            'format' => $this->format,
        ];
    }

    public function __toString(): string
    {
        return "{$this->name}.{$this->extension}";
    }

    public static function make(BookFile $file): self
    {
        $filename = pathinfo($file->path(), PATHINFO_BASENAME);
        $name = pathinfo($file->path(), PATHINFO_FILENAME);
        $path = $file->path();
        $extension = pathinfo($file->path(), PATHINFO_EXTENSION);
        $type = $file->type();
        $format = BookFormatEnum::tryFrom($extension);

        return new self($name, $filename, $path, $extension, $type, $format);
    }
}
