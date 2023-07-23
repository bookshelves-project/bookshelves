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
        $this->typesEnum = BookTypeEnum::toArray();
        $this->formatsEnum = BookFormatEnum::toArray();
    }

    /**
     * Get all files from `storage/data/books`.
     */
    public static function make(int $limit = null): self
    {
        $self = new self(storage_path('app/public/data/books'));

        foreach ($self->typesEnum as $type => $typeValue) {
            $path = "{$self->path}/{$type}";
            $self->files = DirectoryService::make()->parse($path);

            $self->parseFile($type);
        }

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

    private function parseFile(string $type): void
    {
        foreach ($this->files as $key => $path) {
            if (! array_key_exists('extension', pathinfo($path))) {
                continue;
            }

            $extension = pathinfo($path, PATHINFO_EXTENSION);

            if (in_array($extension, ['cb7', 'cba', 'cbr', 'cbt', 'cbz'])) {
                $extension = 'cba';
            }

            if (! array_key_exists($extension, $this->formatsEnum)) {
                continue;
            }

            $format = BookFormatEnum::tryFrom($extension);
            $type = is_string($type) ? BookTypeEnum::from($type) : $type;

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
