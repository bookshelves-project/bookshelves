<?php

namespace App\Services;

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
class SearchEngineService
{
    public function __construct(
        public int $top_limit = 3,
        public int $max_limit = 10,
        public int $results_count = 0,
        public string $search_type = 'collection',
        public ?string $q = null,
        public ?array $types = [],
        public ?Collection $authors = null,
        public ?Collection $series = null,
        public ?Collection $books = null,
        public ?AnonymousResourceCollection $authors_relevant = null,
        public ?AnonymousResourceCollection $series_relevant = null,
        public ?AnonymousResourceCollection $books_relevant = null,
        public ?AnonymousResourceCollection $authors_other = null,
        public ?AnonymousResourceCollection $series_other = null,
        public ?AnonymousResourceCollection $books_other = null,
    ) {
        $this->authors = collect([]);
        $this->series = collect([]);
        $this->books = collect([]);
    }

    /**
     * Create an instance of SearchEngineService from query.
     */
    public static function create(string $q, array|null $types = []): SearchEngineService
    {
        if (empty($types)) {
            $types = ['books', 'series', 'authors'];
        }
        $engine = new SearchEngineService(q: $q, types: $types);

        return $engine->searchEngine();
    }

    /**
     * Find search engine from laravel/scout and execute search.
     */
    public function searchEngine(): SearchEngineService
    {
        $authors = collect([]);
        $series = collect([]);
        $books = collect([]);

        if ('collection' === config('scout.driver')) {
            $results = $this->searchWithCollection();
        } elseif ('meilisearch' === config('scout.driver')) {
            $results = $this->searchWithMeilisearch();
        } else {
            $results = [
                'authors' => $authors,
                'series' => $series,
                'books' => $books,
            ];
        }
        $this->search_type = config('scout.driver');

        /** @var Collection $authors */
        $authors = $results['authors'];

        /** @var Collection $series */
        $series = $results['series'];

        /** @var Collection $books */
        $books = $results['books'];

        $this->results_count += $authors->count();
        $this->results_count += $series->count();
        $this->results_count += $books->count();

        $this->authors = $authors;
        $this->series = $series;
        $this->books = $books;

        $this->authors_relevant = EntityResource::collection($this->authors->splice(0, $this->top_limit));
        $this->series_relevant = EntityResource::collection($this->series->splice(0, $this->top_limit));
        $this->books_relevant = EntityResource::collection($this->books->splice(0, $this->top_limit));

        $this->authors_other = EntityResource::collection($this->authors->splice($this->top_limit, $this->max_limit));
        $this->series_other = EntityResource::collection($this->series->splice($this->top_limit, $this->max_limit));
        $this->books_other = EntityResource::collection($this->books->splice($this->top_limit, $this->max_limit));

        return $this;
    }

    /**
     * Search from embedded search engine.
     */
    private function searchWithCollection(): array
    {
        if (in_array('authors', $this->types)) {
            $authors = Author::whereLike(['name', 'firstname', 'lastname'], $this->q)->with('media')->get();
        }
        if (in_array('authors', $this->types)) {
            $series = Serie::whereLike(['title', 'authors.name'], $this->q)->with(['authors', 'media'])->get();
        }
        if (in_array('authors', $this->types)) {
            $books = Book::whereLike(['title', 'authors.name', 'serie.title', 'identifier.isbn', 'identifier.isbn13'], $this->q)
                ->with(['authors', 'media', 'identifier'])
                ->doesntHave('serie')
                ->orderBy('serie_id')
                ->orderBy('volume')->get();
        }

        return [
            'authors' => $authors ?? collect([]),
            'series' => $series ?? collect([]),
            'books' => $books ?? collect([]),
        ];
    }

    /**
     * Search with meilisearch.
     */
    private function searchWithMeilisearch(): array
    {
        if (in_array('authors', $this->types)) {
            $authors = Author::search($this->q)->get();
        }
        if (in_array('series', $this->types)) {
            $series = Serie::search($this->q)->get();
        }
        if (in_array('books', $this->types)) {
            $books = Book::search($this->q)->get();
        }

        return [
            'authors' => $authors ?? collect([]),
            'series' => $series ?? collect([]),
            'books' => $books ?? collect([]),
        ];
    }
}
