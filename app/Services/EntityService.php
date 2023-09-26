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
     *
     * @return Collection<int, Book>
     */
    public static function filterRelated(Book $book): Collection
    {
        // get related books by tags, same lang
        $relatedBooks = Book::withAllTags($book->tags)
            ->with(['serie'])
            ->whereLanguageSlug($book->language_slug)
            ->get();

        // get serie of current book
        $serieBooks = Serie::whereSlug($book->serie?->slug)->first();
        // get books of this serie
        $serieBooks = $serieBooks?->books()->with(['serie'])->get();

        // if serie exist
        if ($serieBooks) {
            // remove all books from this serie
            $filtered = $relatedBooks->filter(function (Book $relatedBook) use ($serieBooks) {
                foreach ($serieBooks as $serieBook) {
                    if ($relatedBook->serie) {
                        return $relatedBook->serie->slug != $serieBook->serie->slug;
                    }
                }
            });
            $relatedBooks = $filtered;
        }
        // remove current book
        $relatedBooks = $relatedBooks->filter(fn ($related_book) => $related_book->slug != $book->slug);

        // get series of related
        $seriesList = collect();

        foreach ($relatedBooks as $key => $book) {
            if ($book->serie) {
                $seriesList->add($book->serie);
            }
        }
        // remove all books of series
        $relatedBooks = $relatedBooks->filter(fn (Book $book) => $book->serie === null);

        // unique on series
        $seriesList = $seriesList->unique();

        // merge books and series
        $relatedBooks = $relatedBooks->merge($seriesList);
        $relatedBooks = $relatedBooks->load(['language']);

        // sort entities
        return $relatedBooks->sortBy('slug_sort');
    }
}
