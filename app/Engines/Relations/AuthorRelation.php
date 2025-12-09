<?php

namespace App\Engines\Relations;

use App\Engines\Converter\Modules\AuthorModule;
use App\Models\Author;
use App\Models\Book;
use App\Utils;
use Kiwilan\Ebook\Models\BookAuthor;
use Kiwilan\LaravelNotifier\Facades\Journal;

class AuthorRelation
{
    public static function handle(): void
    {
        Journal::info('AuthorRelation: handle authors...');

        $self = new AuthorRelation;
        $self->createAuthors();
        $self->attachAuthors();
    }

    private function createAuthors(): void
    {
        $items = collect();
        Book::all()->each(function (Book $book) use ($items) {
            $index_path = $book->getIndexAuthorPath();
            if (! file_exists($index_path)) {
                return;
            }

            $data = Utils::unserialize($index_path);

            /** @var BookAuthor $author */
            foreach ($data as $author) {
                $items->add($author);
            }
        });

        $items = $items->filter(fn ($author) => $author !== null);
        $items = $items->unique(fn ($author) => $author->getName())->values();

        AuthorModule::make($items->toArray());
    }

    private function attachAuthors(): void
    {
        Book::all()->each(function (Book $book) {
            $index_path = $book->getIndexAuthorPath();
            if (! file_exists($index_path)) {
                return;
            }

            $authors = Utils::unserialize($index_path);
            $authors = collect($authors)
                ->filter(fn ($author) => $author !== null)
                ->unique(fn ($author) => $author->getName())
                ->values();

            $items = [];
            foreach ($authors as $author) {
                $items[] = Author::where('name', $author->getName())->first();
            }

            if (empty($items)) {
                return;
            }

            $book->authors()->syncWithoutDetaching($items);

            $first = reset($items);
            if ($first) {
                $book->authorMain()->associate($first);
                $book->saveNoSearch();
            }
        });
    }
}
