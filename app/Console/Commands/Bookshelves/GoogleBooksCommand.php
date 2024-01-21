<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\GoogleBookJob;
use App\Models\Book;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

class GoogleBooksCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:google-books';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Improves books with Google Books data.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->title();

        $books = Book::query()
            ->where('google_book_parsed_at', null)
            ->where('isbn10', '!=', null)
            ->orWhere('isbn13', '!=', null)
            ->get();

        foreach ($books as $book) {
            GoogleBookJob::dispatch($book);
        }
    }
}
