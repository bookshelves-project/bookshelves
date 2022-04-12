<?php

namespace App\Engines;

use App\Http\Resources\EntityResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Entity;
use App\Models\Serie;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

/**
 * Search Engine with laravel/scout
 * - https://laravel.com/docs/9.x/scout.
 */
class SearchEngine
{
    /** @var Collection<int,Entity> */
    public ?Collection $list = null;

    /** @var Collection<int,Author> */
    public ?Collection $authors = null;
    /** @var Collection<int,Serie> */
    public ?Collection $series = null;
    /** @var Collection<int,Book> */
    public ?Collection $books = null;

    public ?AnonymousResourceCollection $authors_relevant = null;
    public ?AnonymousResourceCollection $series_relevant = null;
    public ?AnonymousResourceCollection $books_relevant = null;

    public ?AnonymousResourceCollection $authors_other = null;
    public ?AnonymousResourceCollection $series_other = null;
    public ?AnonymousResourceCollection $books_other = null;

    public function __construct(
        public int $top_limit = 3,
        public int $max_limit = 10,
        public int $count = 0,
        public string $search_type = 'collection',
        public ?string $q = null,
        public ?bool $sorted = true,
        public ?array $types = [],
    ) {
    }

    /**
     * Create an instance of SearchEngine from query.
     */
    public static function create(string $q, bool $sorted = true, array|null $types = []): SearchEngine
    {
        if (empty($types)) {
            $types = ['books', 'series', 'authors'];
        }
        $engine = new SearchEngine(q: $q, sorted: $sorted, types: $types);

        return $engine->searchEngine();
    }

    /**
     * Find search engine from laravel/scout and execute search.
     */
    public function searchEngine(): SearchEngine
    {
        $this->authors = collect();
        $this->series = collect();
        $this->books = collect();

        $this->search_type = config('scout.driver');
        $this->search();

        $this->count += $this->authors->count();
        $this->count += $this->series->count();
        $this->count += $this->books->count();

        $authors_relevant = $this->authors->splice(0, $this->top_limit);
        $series_relevant = $this->series->splice(0, $this->top_limit);
        $books_relevant = $this->books->splice(0, $this->top_limit);

        $authors_other = $this->authors->splice($this->top_limit, $this->max_limit);
        $series_other = $this->series->splice($this->top_limit, $this->max_limit);
        $books_other = $this->books->splice($this->top_limit, $this->max_limit);
        if ($this->sorted) {
            $this->authors_relevant = EntityResource::collection($authors_relevant);
            $this->series_relevant = EntityResource::collection($series_relevant);
            $this->books_relevant = EntityResource::collection($books_relevant);

            $this->authors_other = EntityResource::collection($authors_other);
            $this->series_other = EntityResource::collection($series_other);
            $this->books_other = EntityResource::collection($books_other);
        } else {
            $this->list = collect();
            $this->list->push(...$authors_relevant);
            $this->list->push(...$series_relevant);
            $this->list->push(...$books_relevant);
            $this->list->push(...$authors_other);
            $this->list->push(...$series_other);
            $this->list->push(...$books_other);
        }

        return $this;
    }

    /**
     * Search Entity[].
     */
    private function search(): SearchEngine
    {
        $this->entitySearch('authors', Author::class, ['name', 'firstname', 'lastname'], 'media');
        $this->entitySearch('series', Serie::class, ['title', 'authors.name'], ['authors', 'media']);
        $this->entitySearch('books', Book::class, ['title', 'authors.name', 'serie.title', 'isbn10', 'isbn13'], ['authors', 'media']);

        return $this;
    }

    private function entitySearch(string $key, string $class, array $search_on = [], array|string $with = [])
    {
        $scout_search = 'collection' !== $this->search_type;
        if (in_array($key, $this->types)) {
            $this->authors = $scout_search ?
                $class::search($this->q)
                    ->get()
                : $class::whereLike($search_on, $this->q)
                    ->with($with)
                    ->get()
                ;
        }
    }
}
