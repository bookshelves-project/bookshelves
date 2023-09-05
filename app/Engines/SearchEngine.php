<?php

namespace App\Engines;

use App\Class\Entity;
use App\Http\Resources\EntityResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use ReflectionClass;
use Str;

/**
 * Search Engine with laravel/scout
 * - https://laravel.com/docs/10.x/scout.
 */
class SearchEngine
{
    /**
     * List of searchable entities.
     *
     * @var array<class-string, array<string>>
     */
    public const LIST = [
        Author::class => [],
        Serie::class => ['authors', 'language'],
        Book::class => ['authors', 'language', 'serie'],
    ];

    public array $results = [];

    public array $results_relevant = [];

    /** @var Collection<int, Entity> */
    public Collection $results_opds;

    public function __construct(
        public int $top_limit = 3,
        public int $max_limit = 10,
        public int $count = 0,
        public string $search_type = 'collection',
        public ?string $q = null,
        public ?bool $relevant = false,
        public ?bool $opds = false,
        public ?array $types = [],
    ) {
    }

    /**
     * Create an instance of SearchEngine from query.
     */
    public static function make(?string $q = '', bool $relevant = false, bool $opds = false, string|array $types = null): self
    {
        if ('string' === gettype($types)) {
            $types = explode(',', $types);
        }

        if (empty($types)) {
            $types = [
                'authors',
                'series',
                'books',
            ];
        }
        $engine = new self(q: $q, relevant: $relevant, opds: $opds, types: $types);

        return $engine->searchEngine();
    }

    public function json(): JsonResponse
    {
        return response()->json([
            'data' => [
                'count' => empty($this->q) ? 0 : $this->count,
                'type' => $this->search_type,
                'query' => $this->q,
                'results' => empty($this->q) ? [] : (! $this->relevant ? $this->results : []),
                'results_relevant' => empty($this->q) ? [] : (! $this->relevant ? [] : $this->results_relevant),
            ],
        ]);
    }

    /**
     * Find search engine from laravel/scout and execute search.
     */
    public function searchEngine(): SearchEngine
    {
        $this->search_type = config('scout.driver');
        $this->search();

        /** @var Collection $collection */
        foreach ($this->results as $key => $collection) {
            $this->count += $collection->count();
        }

        if ($this->relevant) {
            $this->results_relevant = $this->getRelevantResults();
        }

        if ($this->opds) {
            $this->results_opds = $this->getOpdsResults();
        }

        return $this;
    }

    public function getRelevantResults()
    {
        $list = collect();

        /** @var string $model */
        foreach ($this->results as $model => $results) {
            /** @var AnonymousResourceCollection $collection */
            $collection = $results;
            $json = $collection->toJson();
            $results_list = json_decode($json);
            $relevant_results = array_splice($results_list, 0, $this->top_limit);

            $list->put($model, [
                'relevant' => $relevant_results,
                'other' => $results_list,
            ]);
        }

        return $list->toArray();
    }

    public function getOpdsResults()
    {
        $list = collect();

        /** @var string $model */
        foreach ($this->results as $model => $results) {
            /** @var Collection<int, Entity> $collection */
            $collection = $results;
            $list->push(...$collection);
        }

        return $list;
    }

    /**
     * Search Entity[].
     */
    private function search(): SearchEngine
    {
        foreach (self::LIST as $model => $relations) {
            $this->entitySearch($model, $relations);
        }

        return $this;
    }

    /**
     * Search Entity[].
     *
     * @param  array<string>  $relations
     */
    private function entitySearch(string $model, array $relations)
    {
        $instance = new $model();
        $class = new ReflectionClass($instance);
        $static = $class->getName();
        $name = $class->getShortName();
        $key = Str::plural($name);

        $slug = preg_split('/(?=[A-Z])/', $name);
        $slug = implode('-', $slug);
        $key = Str::plural(Str::slug($slug));

        if (in_array($key, $this->types)) {
            /** @var \Laravel\Scout\Builder */
            $results = $model::search($this->q);

            if ($this->opds) {
                $items = $results->get();
                $this->results[] = $items->splice(0, 20);
            } else {
                $this->results[$key] = EntityResource::collection(
                    $results->get(),
                );
            }
        }
    }
}
