<?php

namespace App\Engines;

use App\Engines\Converter\BookConverter;
use App\Engines\Converter\Modules\AuthorConverter;
use App\Engines\Parser\Models\BookEntity;
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;

/**
 * Create a `Book` and relations.
 */
class ConverterEngine
{
    protected function __construct(
        protected BookEntity $entity,
        protected ?Book $book = null,
        protected bool $isExist = false,
        protected bool $default = false
    ) {
    }

    /**
     * Create a `Book::class` and relations from `BookEntity::class`.
     * Rejected if `BookEntity::class` is `null`.
     */
    public static function make(?BookEntity $entity, bool $default = false): ?ConverterEngine
    {
        if (! $entity) {
            return null;
        }

        $self = new self($entity);
        $self->default = $default;
        $self->book = $self->retrieveBook();

        $bookConverter = BookConverter::make($self->entity, $self->book);
        $self->book = $bookConverter->book();

        return $self;
    }

    private function retrieveBook(): ?Book
    {
        $names = [];

        foreach ($this->entity->authors() as $author) {
            $author = AuthorConverter::make($author);
            $names[] = "{$author->firstname()} {$author->lastname()}";
            $names[] = "{$author->lastname()} {$author->firstname()}";
        }

        $book = Book::whereSlug($this->entity->extra()->titleSlugLang());

        if (! empty($authors_name)) {
            $book = $book->whereHas(
                'authors',
                fn (Builder $query) => $query->whereIn('name', $authors_name)
            );
        }

        $book = $book->whereType($this->entity->file()->type())
            ->first()
        ;

        if ($book) {
            $this->isExist = true;
        }

        return $book;
    }

    public function entity(): BookEntity
    {
        return $this->entity;
    }

    public function book(): ?Book
    {
        return $this->book;
    }

    public function isExist(): bool
    {
        return $this->isExist;
    }

    public function isDefault(): bool
    {
        return $this->default;
    }
}
