<?php

namespace App\Services;

use App\Http\Resources\EntityResource;
use App\Models\Entity;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use ReflectionClass;
use Str;

/**
 * Search Engine with laravel/scout
 * - https://laravel.com/docs/9.x/scout.
 */
class SearchService
{
    public const LIST = [
        Post::class,
    ];

    /** @var Collection<int,Entity> */
    public ?Collection $list = null;

    public array $results = [];

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
     * Create an instance of SearchService from query.
     */
    public static function create(string $q, bool $sorted = true, mixed $types = []): SearchService
    {
        if (! is_array($types)) {
            $types = explode(',', $types);
        }
        if (empty($types)) {
            $types = [
                'posts',
            ];
        }
        $engine = new SearchService(q: $q, sorted: $sorted, types: $types);
        return $engine->searchEngine();
    }

    public function json(): JsonResponse
    {
        return response()->json([
            'data' => [
                'count' => empty($this->q) ? 0 : $this->count,
                'type' => $this->search_type,
                'types' => $this->types,
                'query' => $this->q,
                'results' => empty($this->q) ? [] : $this->results,
            ],
        ]);
    }

    /**
     * Find search engine from laravel/scout and execute search.
     */
    public function searchEngine(): SearchService
    {
        $this->search_type = config('scout.driver');
        $this->search();

        /** @var Collection $collection */
        foreach ($this->results as $key => $collection) {
            $this->count += $collection->count();
        }

        return $this;
    }

    /**
     * Search Entity[].
     */
    private function search(): SearchService
    {
        foreach (self::LIST as $value) {
            $this->entitySearch($value);
        }

        return $this;
    }

    private function entitySearch(string $model)
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
            $this->results[$key] = EntityResource::collection(
                $static::search($this->q) // @phpstan-ignore-line
                    ->get(),
            );
        }
    }
}
