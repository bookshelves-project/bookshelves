<?php

namespace App\Engines\Book;

use Illuminate\Support\Carbon;
use Kiwilan\Steward\Services\DirectoryClearService;

class IndexationEngine
{
    /**
     * @var array<IndexItem>
     */
    protected array $items;

    protected function __construct(
        protected array $paths,
    ) {
    }

    public const CACHE_PATH = 'storage/data/cache';

    public const INDEX_PATH = '00-index-bookshelves.json';

    public static function make(): self
    {
        $self = new self(
            paths: json_decode(file_get_contents(self::indexPath()), true),
        );

        foreach ($self->paths as $item) {
            $self->items[] = $self->item($item);
        }

        return $self;
    }

    public static function clean(): void
    {
        DirectoryClearService::make([
            public_path('storage/data/cache'),
        ]);
    }

    public static function save(string $bookTitle, array $bookData): void
    {
        $cachePath = self::cachePath();
        $indexPath = self::indexPath();
        $bookPath = "{$cachePath}/{$bookTitle}.json";

        if (! file_exists($indexPath)) {
            file_put_contents($indexPath, json_encode([]));
        }
        $indexData = json_decode(file_get_contents($indexPath));
        $indexData[] = $bookPath;

        file_put_contents($indexPath, json_encode($indexData));
        file_put_contents($bookPath, json_encode($bookData));
    }

    public static function cachePath(): string
    {
        return public_path(self::CACHE_PATH);
    }

    public static function indexPath(): string
    {
        return self::cachePath().'/'.self::INDEX_PATH;
    }

    /**
     * @return array<string>
     */
    public function paths(): array
    {
        return $this->paths;
    }

    /**
     * @return array<IndexItem>
     */
    public function items(): array
    {
        return $this->items;
    }

    public function item(string $value): IndexItem
    {
        $contents = file_get_contents($value);
        $contents = json_decode($contents, true);

        return IndexItem::make($contents);
    }

    public function flattenAndUnique(array $data): array
    {
        if (! is_array($data) || ! $data) {
            return [];
        }

        $data = array_filter($data);
        $data = call_user_func_array('array_merge', $data);
        $data = array_map('json_decode', array_unique(array_map('json_encode', $data)));

        return json_decode(json_encode($data), true);
    }

    public function unique(array $data): array
    {
        if (! is_array($data) || ! $data) {
            return [];
        }

        $data = array_filter($data);
        $data = array_unique($data, SORT_REGULAR);
        $data = array_values($data);

        $temp = [];

        foreach ($data as $item) {
            $tempItem = [];

            foreach ($item as $key => $value) {
                if (is_array($value)) {
                    $tempItem[$key] = json_encode($value);
                } else {
                    $tempItem[$key] = $value;
                }
            }
            $temp[] = $tempItem;
        }

        return $temp;
    }

    // private function setTimestamps(array $data): array
    // {
    //     $data['created_at'] = Carbon::now();
    //     $data['updated_at'] = Carbon::now();

    //     return $data;
    // }
}

class IndexItem
{
    protected function __construct(
        protected string $uuid,
        protected array $book,
        protected array $relations,
        protected ?array $authors = [],
        protected ?array $tags = [],
        protected ?array $publisher = null,
        protected ?array $language = null,
        protected ?array $serie = null,
        protected ?string $cover = null,
    ) {
    }

    public static function make(array $data): self
    {
        $book = $data['book'];
        unset($book['isbn']);
        $book = IndexItem::setTimestamps($book);

        $relations = $data['relations'];
        $authors = $relations['authors'] ?? [];
        $temp = [];

        foreach ($authors as $author) {
            unset($author['title']);
            $temp[] = $author;
        }
        $authors = $temp;

        $tags = $relations['tags'] ?? [];
        $publisher = $relations['publisher'] ?? null;
        unset($publisher['first_char']);
        $language = $relations['language'] ?? null;
        $serie = $relations['serie'] ?? null;
        unset($serie['authors']);
        $cover = $relations['cover'] ?? null;

        return new self(
            uuid: $book['uuid'],
            book: $book,
            relations: $relations,
            authors: $authors,
            tags: $tags,
            publisher: $publisher,
            language: $language,
            serie: $serie,
            cover: $cover,
        );
    }

    private static function setTimestamps(array $data): array
    {
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();

        return $data;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function book(): array
    {
        return $this->book;
    }

    public function relations(): array
    {
        return $this->relations;
    }

    public function authors(): ?array
    {
        return $this->authors;
    }

    public function tags(): ?array
    {
        return $this->tags;
    }

    public function publisher(): ?array
    {
        return $this->publisher;
    }

    public function language(): ?array
    {
        return $this->language;
    }

    public function serie(): ?array
    {
        return $this->serie;
    }

    public function cover(): ?string
    {
        return $this->cover;
    }
}
