<?php

namespace App\Engines\Parser\Parsers;

use App\Enums\BookTypeEnum;
use Kiwilan\Steward\Services\DirectoryParserService;

class BookFilesParser
{
    /** @var string[] */
    protected mixed $files = [];

    /** @var BookFile[] */
    protected array $items = [];

    protected function __construct(
        protected string $path,
        protected int $i = 0,
        protected array $typesEnum = [],
        protected array $formatsEnum = [],
    ) {
        $this->typesEnum = BookTypeEnum::toArray();
    }

    /**
     * Get all files from `storage/data/books`.
     *
     * @return false|FilesTypeParser[]
     */
    public static function make(int $limit = null)
    {
        $self = new self(
            path: storage_path('app/public/data/books'),
        );

        $items = [];

        foreach ($self->typesEnum as $type => $typeValue) {
            $service = DirectoryParserService::make($self->path);
            $self->files = $service->files();

            $self->parseFile($type);
        }

        if ($limit) {
            return array_slice($items, 0, $limit);
        }

        return $items;
    }

    public function path(): string
    {
        return $this->path;
    }

    /**
     * @return BookFile[]
     */
    public function items(): array
    {
        return $this->items;
    }

    /**
     * @param  string[]  $files
     */
    private function parseFile(string $type): void
    {
        foreach ($this->files as $key => $path) {
            if (array_key_exists('extension', pathinfo($path))) {
                $ext = pathinfo($path, PATHINFO_EXTENSION);

                if (array_key_exists($ext, $this->formatsEnum)) {
                    $this->i++;
                    $this->items["{$this->i}"] = BookFile::make(BookTypeEnum::from($type), $path);
                }
            }
        }
    }
}

class BookFile
{
    protected function __construct(
        protected ?BookTypeEnum $type,
        protected ?string $path,
    ) {
    }

    public static function make(BookTypeEnum $type, string $path): self
    {
        return new self($type, $path);
    }

    public function type(): ?BookTypeEnum
    {
        return $this->type;
    }

    public function path(): ?string
    {
        return $this->path;
    }
}
