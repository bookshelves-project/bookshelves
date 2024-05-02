<?php

namespace App\Jobs;

use App\Engines\Book\BookFileItem;
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

        $libraries = Library::all();
        $current_books = Book::all()
            ->map(fn (Book $book) => $book->physical_path)
            ->toArray();

        foreach ($libraries as $library) {
            $this->parseFiles($library, $current_books);
        }

        ExtrasJob::dispatch();
    }

    /**
     * @param  string[]  $current_books
     */
    private function parseFiles(Library $library, array $current_books)
    {
        $path = $library->getJsonPath();
        $contents = file_get_contents($path);
        $files = (array) json_decode($contents, true);
        if ($this->limit && count($files) > $this->limit) {
            $files = array_slice($files, 0, $this->limit);
        }
        $count = count($files);

        $i = 0;
        foreach ($files as $file) {
            $i++;

            $file = BookFileItem::fromArray($file, $library);
            if ($this->fresh) {
                BookJob::dispatch($file, "{$i}/{$count}");
            } else {
                if (in_array($file->path(), $current_books, true)) {
                    continue;
                }

                BookJob::dispatch($file, "{$i}/{$count}");
            }
        }
    }
}
