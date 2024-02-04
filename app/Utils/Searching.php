<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Builder;

class Searching
{
    protected function __construct(
        protected string $value,
        protected array $results = [],
        protected int|false $limit = 20,
    ) {
    }

    /**
     * Search for movies, tv shows, collections, and members.
     */
    public static function search(string $value, int|false $limit = 20): self
    {
        $self = new self($value, [], $limit);

        $results = collect([]);

        $books = $self->searchModel(\App\Models\Book::class);
        $series = $self->searchModel(\App\Models\Serie::class);
        $authors = $self->searchModel(\App\Models\Author::class);

        $results = $results->merge($books);
        $results = $results->merge($series);
        $results = $results->merge($authors);

        $results = $results->values();
        $self->results = $results->toArray();

        return $self;
    }

    public function results(): array
    {
        return $this->results;
    }

    private function searchModel(string $model)
    {
        /** @var Builder */
        $results = $model::search($this->value);

        if ($this->limit) {
            $results = $results->take($this->limit);
        }

        return $results->get();
    }
}
