<?php

namespace App\Engines\Book\File;

use App\Enums\BookFormatEnum;
use App\Facades\Bookshelves;
use App\Models\Library;
use Kiwilan\FileList\FileList;
use Kiwilan\LaravelNotifier\Facades\Journal;

class BookFileScanner
{
    protected mixed $files = [];

    /** @var BookFileItem[] */
    protected array $items = [];

    /**
     * @var string[]
     */
    protected array $skip_extensions = [];

    protected function __construct(
        protected Library $library,
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
    public static function make(Library $library, ?int $limit = null): ?self
    {
        $path = $library->path;
        if (! $library->path_is_valid) {
            return null;
        }

        $self = new self($library, $path);
        $self->files = $self->scan($limit);
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
    private function scan(?int $limit = null): array
    {
        $engine = Bookshelves::analyzerEngine();

        if ($this->library->path_is_valid) {
            Journal::info("BookFileScanner: {$this->library->name} scanning: {$this->library->path} (engine: {$engine})");
        } else {
            Journal::warning("BookFileScanner: {$this->library->name} path not found: {$this->library->path}");

            return [];
        }

        $jsonPath = $this->library->getJsonPath();
        $browser = FileList::make($this->library->path)
            ->saveAsJson($jsonPath)
            ->skipExtensions($this->skip_extensions);

        if ($limit) {
            $browser->limit($limit);
        }

        if ($engine === 'scout') {
            $browser->withScout();
        }

        $browser->run();

        Journal::debug("BookFileScanner: {$this->library->name} time elapsed: {$browser->getTimeElapsed()}");

        return $browser->getFiles();
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
            $bookFile = BookFileItem::make($format, $this->library, $path);
            if ($bookFile) {
                $items["{$this->i}"] = $bookFile;
            }
        }

        return $items;
    }
}
