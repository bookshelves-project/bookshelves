<?php

namespace App\Jobs\Cover;

use App\Engines\Converter\Modules\CoverModule;
use App\Facades\Bookshelves;
use App\Models\Book;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Kiwilan\LaravelNotifier\Facades\Journal;

class BookCoverJob implements ShouldQueue
{
    use Batchable, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Book $book,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (Bookshelves::verbose()) {
            Journal::debug("BookCoverJob: {$this->book->title}...");
        }

        CoverModule::make($this->book);
    }
}
