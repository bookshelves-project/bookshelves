<?php

namespace App\Engines\Book\Parser\Models;

class BookEntityCover
{
    protected ?string $name = null;

    protected ?string $extension = null;

    protected ?string $file = null;

    protected bool $isExists = false;

    protected bool $isFirst = false;

    public function __construct(
    ) {
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function extension(): ?string
    {
        return $this->extension;
    }

    public function file(): ?string
    {
        return $this->file;
    }

    public function isExists(): bool
    {
        return $this->isExists;
    }

    public function isFirst(): bool
    {
        return $this->isFirst;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setExtension(?string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function setIsExists(bool $isExists = true): self
    {
        $this->isExists = $isExists;

        return $this;
    }

    public function setIsFirst(bool $isFirst = true): self
    {
        $this->isFirst = $isFirst;

        return $this;
    }

    public static function make(?string $name, ?string $extension, ?string $file): self
    {
        return new self($name, $extension, $file);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'extension' => $this->extension,
            'file' => $this->file,
            'isExists' => $this->isExists,
            'isFirst' => $this->isFirst,
        ];
    }

    public function __toString(): string
    {
        return "{$this->name}.{$this->extension}";
    }
}
