<?php

namespace App\Jobs;

use App\Engines\Book\File\BookFileItem;
use App\Models\Book;
use App\Models\File;
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
        $bookFiles = (array) json_decode(file_get_contents($library->getJsonPath()), true);
        $count = count($bookFiles);

        $files = File::query()
            ->where('library_id', $library->id)
            ->get()
            ->map(fn (File $file) => $file->path)
            ->toArray();

        $bookFilesToParse = $this->findBooksToParse($bookFiles, $files);
        $filesToDelete = $this->findBooksToDelete($bookFiles, $files);
        $this->deleteBooks($filesToDelete);

        $i = 0;
        foreach ($bookFilesToParse as $bookFile) {
            $i++;

            $bookFileItem = BookFileItem::fromArray($bookFile, $library);
            BookJob::dispatch($bookFileItem, "{$i}/{$count}");

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

    /**
     * @param  string[]  $files
     */
    private function findBooksToParse(array $bookFiles, array $files): array
    {
        $bookFilesToParse = array_filter($bookFiles, function ($bookFile) use ($files) {
            if (! in_array($bookFile['path'], $files, true)) {
                $filesToParse[] = $bookFile;

                return true;
            }

            return false;
        });

        return array_values($bookFilesToParse);
    }

    /**
     * @param  string[]  $files
     */
    private function findBooksToDelete(array $bookFiles, array $files): array
    {
        $filesToDelete = array_filter($files, function ($file) use ($bookFiles) {
            if (! in_array($file, array_column($bookFiles, 'path'), true)) {
                return true;
            }

            return false;
        });

        return array_values($filesToDelete);
    }

    private function deleteBooks(array $filesToDelete)
    {
        $files = File::query()
            ->whereIn('path', $filesToDelete)
            ->get();

        Journal::info("BookWrapperJob: delete {$files->count()} books");

        foreach ($files as $file) {
            $file->delete();
        }
    }
}
