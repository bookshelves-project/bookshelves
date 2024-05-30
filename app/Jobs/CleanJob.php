<?php

namespace App\Jobs;

use App\Models\Book;
use App\Models\Library;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Services\DirectoryService;

class CleanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $libraries = Library::all();

        foreach ($libraries as $library) {
            $this->deleteOrphanBooks($library);
        }

        DirectoryService::make()->clearDirectory(storage_path('app/cache'));
    }

    private function deleteOrphanBooks(Library $library)
    {
        $contents = file_get_contents($library->getJsonPath());
        $files = (array) json_decode($contents, true);

        $books = Book::query()
            ->where('library_id', $library->id)
            ->get()
            ->map(fn (Book $book) => $book->physical_path)
            ->toArray();

        if (empty($books)) {
            Journal::warning("Clean: {$library->name} no books detected");

            return;
        }

        $files = array_map(fn ($file) => $file['path'], $files);

        $orphans = array_diff($books, $files);
        $books = Book::query()
            ->whereIn('physical_path', $orphans)
            ->get();

        Journal::info("Clean: {$library->name} {$books->count()}");

        foreach ($books as $book) {
            $book->delete();
        }
    }
}
