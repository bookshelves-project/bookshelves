<?php

namespace App\Jobs;

use App\Engines\Book\File\BookFileItem;
use App\Models\Book;
use App\Models\Library;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\LaravelNotifier\Facades\Journal;

class BookWrapperJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public bool $fresh = false,
        public ?int $limit = null,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Journal::info('BookWrapperJob: create BookJob for each item...', [
            'fresh' => $this->fresh,
            'limit' => $this->limit,
        ]);

        $current_books = [];
        // $current_books = Book::all()
        //     ->map(fn (Book $book) => $book->file->path)
        //     ->toArray();

        // if (empty($current_books)) {
        //     Journal::warning('BookWrapperJob: no books detected');

        //     return;
        // }

        foreach (Library::inOrder() as $library) {
            $this->parseFiles($library, $current_books);
        }

        ExtrasJob::dispatch();
    }

    /**
     * @param  string[]  $current_books
     */
    private function parseFiles(Library $library, array $current_books)
    {
        $files = (array) json_decode(file_get_contents($library->getJsonPath()), true);
        $count = count($files);

        $i = 0;
        foreach ($files as $file) {
            $i++;

            $file = BookFileItem::fromArray($file, $library);
            BookJob::dispatch($file, "{$i}/{$count}");

            // if ($this->fresh) {
            //     BookJob::dispatch($file, "{$i}/{$count}");
            // } else {
            //     if (in_array($file->path(), $current_books, true)) {
            //         continue;
            //     }

            //     BookJob::dispatch($file, "{$i}/{$count}");
            // }
        }
    }
}
