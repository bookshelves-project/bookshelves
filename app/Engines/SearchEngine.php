<?php

namespace App\Engines;

use App\Http\Resources\EntityResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

/**
 * Search Engine with laravel/scout
 * - https://laravel.com/docs/8.x/scout.
 */
class SearchEngine
{
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
        public ?array $types = [],
    ) {
    }

    /**
     * Create an instance of SearchEngine from query.
     */
    public static function create(string $q, array|null $types = []): SearchEngine
    {
        if (empty($types)) {
            $types = ['books', 'series', 'authors'];
        }
        $engine = new SearchEngine(q: $q, types: $types);

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

        $this->authors_relevant = EntityResource::collection($this->authors->splice(0, $this->top_limit));
        $this->series_relevant = EntityResource::collection($this->series->splice(0, $this->top_limit));
        $this->books_relevant = EntityResource::collection($this->books->splice(0, $this->top_limit));

        $this->authors_other = EntityResource::collection($this->authors->splice($this->top_limit, $this->max_limit));
        $this->series_other = EntityResource::collection($this->series->splice($this->top_limit, $this->max_limit));
        $this->books_other = EntityResource::collection($this->books->splice($this->top_limit, $this->max_limit));

        return $this;
    }

    /**
     * Search Entity[].
     */
    private function search(): SearchEngine
    {
        $scout_search = 'collection' !== $this->search_type;
        if (in_array('authors', $this->types)) {
            $this->authors = $scout_search ?
                    Author::search($this->q)
                        ->get()
                    : Author::whereLike(['name', 'firstname', 'lastname'], $this->q)
                        ->with('media')
                        ->get()
                    ;
        }
        if (in_array('series', $this->types)) {
            $this->series = $scout_search ?
                Serie::search($this->q)
                    ->get()
                : Serie::whereLike(['title', 'authors.name'], $this->q)
                    ->with(['authors', 'media'])
                    ->get()
                ;
        }
        if (in_array('books', $this->types)) {
            $this->books = $scout_search ?
                Book::search($this->q)
                    ->get()
                : Book::whereLike(['title', 'authors.name', 'serie.title', 'isbn10', 'isbn13'], $this->q)
                    ->with(['authors', 'media'])
                    ->get()
                ;
        }

        return $this;
    }
}
