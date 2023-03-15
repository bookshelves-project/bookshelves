<?php

namespace App\Services;

use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Support\Collection;

class EntityService
{
    /**
     * Give an Entity output.
     *
     * @return Author|Book|Serie
     */
    public static function entityOutput(mixed $class)
    {
        /** @var Author|Book|Serie */
        return $class;
    }

    /**
     * Get Book or Serie related to a Book from Tag[].
     */
    public static function filterRelated(Book $book): Collection
    {
        // get related books by tags, same lang
        $related_books = Book::withAllTags($book->tags)
            ->whereLanguageSlug($book->language_slug)
            ->get()
        ;

        // get serie of current book
        $serie_books = Serie::whereSlug($book->serie?->slug)->first();
        // get books of this serie
        $serie_books = $serie_books?->books;

        // if serie exist
        if ($serie_books) {
            // remove all books from this serie
            $filtered = $related_books->filter(function ($book) use ($serie_books) {
                foreach ($serie_books as $serie_book) {
                    if ($book->serie) {
                        return $book->serie->slug != $serie_book->serie->slug;
                    }
                }
            });
            $related_books = $filtered;
        }
        // remove current book
        $related_books = $related_books->filter(function ($related_book) use ($book) {
            return $related_book->slug != $book->slug;
        });

        // get series of related
        $series_list = collect();
        foreach ($related_books as $key => $book) {
            if ($book->serie) {
                $series_list->add($book->serie);
            }
        }
        // remove all books of series
        $related_books = $related_books->filter(function ($book) {
            return null === $book->serie;
        });

        // unique on series
        $series_list = $series_list->unique();

        // merge books and series
        $related_books = $related_books->merge($series_list);

        // sort entities
        return $related_books->sortBy('slug_sort');
    }
}
