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
    public static function search(?string $value, int|false $limit = 20): self
    {
        if (! $value) {
            return new self('', [], $limit);
        }

        $self = new self($value, [], $limit);

        $results = collect([]);

        $books = $self->searchModel(\App\Models\Book::class, 'Novel');
        $series = $self->searchModel(\App\Models\Serie::class, 'Serie');
        $authors = $self->searchModel(\App\Models\Author::class, 'Author');

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

    private function searchModel(string $model, string $type)
    {
        /** @var Builder */
        $results = $model::search($this->value);

        if ($this->limit) {
            $results = $results->take($this->limit);
        }

        $items = collect();
        $results->get()->each(function ($item) use ($items, $model, $type) {
            $item->loadMissing(['media']);
            if ($model === \App\Models\Book::class || $model === \App\Models\Serie::class) {
                $item->loadMissing(['authors', 'language']);
            }

            $item->entity_type = $type; // @phpstan-ignore-line
            $items->push($item);
        });

        return $items;
    }
}
