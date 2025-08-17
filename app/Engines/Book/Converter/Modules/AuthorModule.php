<?php

namespace App\Engines\Book\Converter\Modules;

use App\Jobs\Author\AuthorJob;
use App\Models\Author;
use Illuminate\Support\Collection;
use Kiwilan\Ebook\Ebook;
use Kiwilan\Ebook\Models\BookAuthor;

class AuthorModule
{
    /**
     * Handle Authors from Ebook.
     *
     * @param  BookAuthor[]  $authors
     * @return Collection<int, Author>
     */
    public static function make(array $authors): Collection
    {
        $self = new self;

        // `BookAuthor` to `AuthorModuleItem`
        $items = array_filter($authors, fn (BookAuthor $author) => $author->getName() !== null);
        if (empty($items)) {
            $items[] = $self->createAnonymousAuthor();
        }

        /** @var Collection<int, Author> $authors */
        $authors = collect();

        // `AuthorModuleItem` to `Author`
        foreach ($items as $item) {
            $authors->push(AuthorModuleItem::make($item)->toAuthor());
        }

        $authorsSaved = collect();
        foreach ($authors as $author) {
            $exists = Author::query()
                ->where('name', $author->name)
                ->first();

            if ($exists) {
                $author = $exists;
            } else {
                $author->saveNoSearch();
                AuthorJob::dispatch($author);
            }

            $authorsSaved->push($author);
        }

        return $authorsSaved;
    }

    private function createAnonymousAuthor(): BookAuthor
    {
        return new BookAuthor(
            name: 'Anonymous',
            role: 'aut'
        );
    }
}
