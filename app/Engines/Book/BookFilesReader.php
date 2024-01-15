<?php

namespace App\Engines\Book;

use App\Enums\BookFormatEnum;
use App\Enums\BookTypeEnum;
use Kiwilan\Steward\Services\DirectoryService;

class BookFilesReader
{
    protected mixed $files = [];

    /** @var BookFileReader[] */
    protected array $items = [];

    protected function __construct(
        protected string $path,
        protected int $i = 0,
        protected array $typesEnum = [],
        protected array $formatsEnum = [],
    ) {
        $this->formatsEnum = BookFormatEnum::toArray();
    }

    /**
     * Get all files from `storage/data/books`.
     */
    public static function make(?int $limit = null): self
    {
        $path = config('bookshelves.directory');

        if (! str_starts_with($path, '/')) {
            $path = base_path($path);
        }
        $self = new self($path);
        $self->files = DirectoryService::make()->parse($self->path);
        $self->parseFiles();

        if ($limit) {
            $self->items = array_slice($self->items, 0, $limit);
        }

        return $self;
    }

    public function path(): string
    {
        return $this->path;
    }

    /**
     * @return BookFileReader[]
     */
    public function items(): array
    {
        return $this->items;
    }

    private function parseFiles(): void
    {
        foreach ($this->files as $key => $path) {
            if (! array_key_exists('extension', pathinfo($path))) {
                continue;
            }

            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $type = BookTypeEnum::unknown;

            if (in_array($extension, ['cb7', 'cba', 'cbr', 'cbt', 'cbz'])) {
                $extension = 'cba';
                $type = BookTypeEnum::comic;
            }

            if (in_array($extension, ['epub'])) {
                $extension = 'cba';
                $type = BookTypeEnum::novel;
            }

            if (in_array($extension, ['pdf'])) {
                $extension = 'cba';
                $type = BookTypeEnum::comic;
            }

            if (! array_key_exists($extension, $this->formatsEnum)) {
                continue;
            }

            $format = BookFormatEnum::tryFrom($extension);

            $this->i++;
            $this->items["{$this->i}"] = BookFileReader::make($format, $type, $path);
        }
    }
}

class BookFileReader
{
    protected function __construct(
        protected ?BookFormatEnum $format,
        protected ?BookTypeEnum $type,
        protected ?string $path,
    ) {
    }

    public static function make(BookFormatEnum $format, BookTypeEnum $type, string $path): self
    {
        return new self($format, $type, $path);
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
