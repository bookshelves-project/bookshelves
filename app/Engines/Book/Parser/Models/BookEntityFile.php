<?php

namespace App\Engines\Book\Parser\Models;

use App\Engines\Book\Parser\Utils\BookFileReader;
use App\Enums\BookFormatEnum;
use App\Enums\BookTypeEnum;

class BookEntityFile
{
    protected function __construct(
        protected ?string $name = null,
        protected ?string $filename = null,
        protected ?string $path = null,
        protected ?string $extension = null,
        protected ?string $extensionFormat = null,
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

    public function extensionFormat(): ?string
    {
        return $this->extensionFormat;
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
            'extensionFormat' => $this->extensionFormat,
            'type' => $this->type,
            'format' => $this->format,
        ];
    }

    public function __toString(): string
    {
        return "{$this->name}.{$this->extension}";
    }

    public static function make(BookFileReader $file): self
    {
        $filename = pathinfo($file->path(), PATHINFO_BASENAME);
        $name = pathinfo($file->path(), PATHINFO_FILENAME);
        $path = $file->path();
        $extension = pathinfo($file->path(), PATHINFO_EXTENSION);
        $extensionFormat = $file->format()->value;
        $type = $file->type();
        $format = $file->format();

        return new self($name, $filename, $path, $extension, $extensionFormat, $type, $format);
    }
}
