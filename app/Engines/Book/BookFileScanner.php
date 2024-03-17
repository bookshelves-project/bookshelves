<?php

namespace App\Engines\Book;

use App\Enums\BookFormatEnum;
use App\Enums\BookTypeEnum;
use App\Facades\Bookshelves;
use Illuminate\Support\Facades\File;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Utils\BashCommand;
use Kiwilan\Steward\Utils\Json;
use SplFileInfo;

class BookFileScanner
{
    protected mixed $files = [];

    /** @var BookFileItem[] */
    protected array $items = [];

    protected function __construct(
        protected BookTypeEnum $type,
        protected string $path,
        protected int $i = 0,
        protected array $typesEnum = [],
        protected array $formatsEnum = [],
        protected int $count = 0,
    ) {
        $this->formatsEnum = BookFormatEnum::toArray();
    }

    /**
     * Get all files.
     */
    public static function make(BookTypeEnum $type): ?self
    {
        $path = $type->libraryPath();
        if (! $path) {
            return null;
        }

        $self = new self($type, $path);
        $self->files = $self->scan();
        $self->items = $self->parseFiles();

        $self->items = array_values($self->items);
        $self->count = count($self->items);

        return $self;
    }

    public function path(): string
    {
        return $this->path;
    }

    /**
     * @return BookFileItem[]
     */
    public function items(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return $this->count;
    }

    /**
     * @return string[]
     */
    private function scan(): array
    {
        $name = "{$this->type->value}s";
        $scan_path = "{$this->path}";

        if (! file_exists($scan_path)) {
            Journal::warning("BookFileScanner: {$name} path not found: {$scan_path}");

            return [];
        }

        if (Bookshelves::analyzerEngine() === 'native') {
            $files = File::allFiles($scan_path);

            return array_map(fn (SplFileInfo $file) => $file->getPathname(), $files);
        }

        $path = storage_path('app/data');
        $books_path = "{$path}/{$name}.json";
        $process = new BashCommand('scanner', ['parse', "-o={$books_path}", $scan_path]);
        $process->execute();

        $json = new Json($books_path);

        return $json->toArray();
    }

    /**
     * @return BookFileItem[]
     */
    private function parseFiles(): array
    {
        $items = [];
        foreach ($this->files as $key => $path) {
            if (! array_key_exists('extension', pathinfo($path))) {
                continue;
            }

            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $format = BookFormatEnum::fromExtension($extension);

            if (! array_key_exists($format->value, $this->formatsEnum)) {
                continue;
            }

            if ($format->value === BookFormatEnum::unknown->value) {
                continue;
            }

            $this->i++;
            $items["{$this->i}"] = BookFileItem::make($format, $this->type, $path);
        }

        return $items;
    }
}
