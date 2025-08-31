<?php

namespace App\Jobs\Index;

use App\Engines\BookshelvesUtils;
use App\Engines\Converter\Modules\AuthorModule;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Kiwilan\Ebook\Models\BookAuthor;
use Kiwilan\LaravelNotifier\Facades\Journal;

class AuthorJob implements ShouldQueue
{
    use Batchable, Dispatchable, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Journal::info('AuthorJob: handle authors...');

        $this->createAuthors();
        $this->attachAuthors();

        Journal::info('AuthorJob: done.');
    }

    private function createAuthors(): void
    {
        Journal::info('AuthorJob: parse indexes of books...');
        $items = collect();
        Book::all()->each(function (Book $book) use ($items) {
            $index_path = $book->getIndexAuthorPath();
            if (! file_exists($index_path)) {
                return;
            }

            $data = BookshelvesUtils::unserialize($index_path);

            /** @var BookAuthor $author */
            foreach ($data as $author) {
                $items->add($author);
            }
        });

        Journal::info('AuthorJob: clean list...');
        $items = $items->filter(fn ($author) => $author !== null);
        $items = $items->unique(fn ($author) => $author->getName())->values();

        Journal::info('AuthorJob: create authors...');
        AuthorModule::make($items->toArray());
        Journal::info('AuthorJob: done.');
    }

    private function attachAuthors(): void
    {
        Journal::info('AuthorJob: attach authors...');
        Book::all()->each(function (Book $book) {
            $index_path = $book->getIndexAuthorPath();
            if (! file_exists($index_path)) {
                return;
            }

            $authors = BookshelvesUtils::unserialize($index_path);
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
        Journal::info('AuthorJob: attached authors done.');
    }
}
