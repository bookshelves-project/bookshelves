<?php

namespace App\Engines\Book;

use App\Engines\Book\Converter\BookConverter;
use App\Engines\Book\Converter\Modules\AuthorConverter;
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Kiwilan\Ebook\Ebook;

/**
 * Create a `Book` and relations.
 */
class ConverterEngine
{
    protected function __construct(
        protected Ebook $ebook,
        protected BookFileItem $file,
        protected ?Book $book = null,
        protected bool $isExist = false,
        protected bool $default = false
    ) {
    }

    /**
     * Create a `Book::class` and relations from `Ebook::class`.
     */
    public static function make(Ebook $ebook, BookFileItem $file, bool $default = false): ?ConverterEngine
    {
        $self = new self($ebook, $file);
        $self->default = $default;
        $self->book = $self->retrieveBook();

        $converter = BookConverter::make($self->ebook, $file->type(), $self->book);
        $self->book = $converter->book();

        return $self;
    }

    public function retrieveBook(): ?Book
    {
        $book = null;
        $names = [];

        foreach ($this->ebook->getAuthors() as $author) {
            $author = AuthorConverter::make($author);
            $names[] = "{$author->firstname()} {$author->lastname()}";
            $names[] = "{$author->lastname()} {$author->firstname()}";
        }

        $book = Book::whereSlug($this->ebook->getMetaTitle()->getSlug());

        if (! empty($names)) {
            $book = $book->whereHas(
                'authors',
                fn (Builder $query) => $query->whereIn('name', $names)
            );
        }

        $book = $book->whereType($this->ebook->getExtension())->first();

        if ($book) {
            $this->isExist = true;
        }

        return $book;
    }

    public function ebook(): Ebook
    {
        return $this->ebook;
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
