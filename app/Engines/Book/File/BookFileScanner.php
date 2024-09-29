<?php

namespace App\Engines\Book\File;

use App\Enums\BookFormatEnum;
use App\Facades\Bookshelves;
use App\Models\Library;
use Kiwilan\FileList\FileList;
use Kiwilan\LaravelNotifier\Facades\Journal;

class BookFileScanner
{
    /** @var string[] */
    protected array $paths = [];

    /**
     * @var string[]
     */
    protected array $skipExtensions = [];

    protected function __construct(
        protected Library $library,
        protected string $path,
        protected int $i = 0,
        protected array $typesEnum = [],
        protected int $count = 0,
    ) {}

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
        $self->paths = $self->scan($limit);

        Journal::debug("BookFileScanner: build book files from {$library->name}...");

        $self->paths = array_values($self->paths);
        $self->count = count($self->paths);

        return $self;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string[]
     */
    public function getPaths(): array
    {
        return $this->paths;
    }

    public function getCount(): int
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
            ->onlyExtensions(BookFormatEnum::ALLOWED_EXTENSIONS)
            ->skipExtensions($this->skipExtensions);

        if ($limit) {
            $browser->limit($limit);
        }

        if ($engine === 'scout-seeker') {
            $browser->withScoutSeeker();
        }

        $browser->run();

        if ($browser->getCommand()) {
            $name = $browser->getCommand()->getName();
            $command = $browser->getCommand()->getCommand();
            $user = $browser->getCommand()->getUser();
            Journal::debug("BookFileScanner: {$this->library->name} `{$name}` command: `{$command}` by `{$user}`", $browser->getCommand()->toArray());
        }

        Journal::debug("BookFileScanner: {$this->library->name} time elapsed: {$browser->getTimeElapsed()}");

        return $browser->getFiles();
    }

    /**
     * @return BookFileItem[]
     */
    public function toBookFileItems(): array
    {
        $items = [];
        foreach ($this->paths as $path) {
            $this->i++;
            $bookFile = BookFileItem::make($path, $this->library->id);
            if ($bookFile) {
                $items["{$this->i}"] = $bookFile;
            }
        }

        return $items;
    }
}
