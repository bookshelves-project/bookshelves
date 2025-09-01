<?php

namespace App\Jobs\Clean;

use App\Models\Author;
use App\Models\Book;
use App\Models\File;
use App\Models\Library;
use App\Models\Serie;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Services\DirectoryService;

class CleanJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Journal::debug('CleanJob: clean books, authors and series...');

        $this->cleanBooks();
        $this->cleanAuthors();
        $this->cleanSeries();

        DirectoryService::make()->clearDirectory(storage_path('app/cache'));
    }

    /**
     * Clean Books with orphaned files.
     */
    private function cleanBooks()
    {
        Library::all()->each(function (Library $library) {
            File::query()
                ->where('library_id', $library->id)
                ->doesntHave('book')
                ->doesntHave('audiobookTracks')
                ->delete();

            Book::query()
                ->where('library_id', $library->id)
                ->doesntHave('file')
                ->doesntHave('audiobookTracks')
                ->get();
        });
    }

    /**
     * Clean Authors without Books.
     */
    private function cleanAuthors(): void
    {
        $authors = Author::query()
            ->whereDoesntHave('books')
            ->get();

        if ($authors->count() > 0) {
            Journal::info("CleanJob: authors {$authors->count()} to delete.");
        }

        foreach ($authors as $author) {
            $author->delete();
        }
    }

    /**
     * Clean Series without Books.
     */
    private function cleanSeries(): void
    {
        $series = Serie::query()
            ->whereDoesntHave('books')
            ->get();

        if ($series->count() > 0) {
            Journal::info("CleanJob: series {$series->count()} to delete.");
        }

        foreach ($series as $serie) {
            $serie->delete();
        }
    }
}
