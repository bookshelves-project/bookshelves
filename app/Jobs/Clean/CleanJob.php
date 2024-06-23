<?php

namespace App\Jobs\Clean;

use App\Models\Author;
use App\Models\File;
use App\Models\Library;
use App\Models\Serie;
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
    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach (Library::all() as $library) {
            $this->cleanBooks($library);
        }

        $this->cleanAuthors();
        $this->cleanSeries();

        DirectoryService::make()->clearDirectory(storage_path('app/cache'));
    }

    private function cleanBooks(Library $library)
    {
        $contents = file_get_contents($library->getJsonPath());
        $paths = (array) json_decode($contents, true);

        $files = File::query()
            ->where('library_id', $library->id)
            ->get()
            ->map(fn (File $file) => $file->path)
            ->toArray();

        if (empty($files)) {
            Journal::debug("CleanJob: {$library->name} no books detected");

            return;
        }

        $paths = array_map(fn (string $path) => $path, $paths);

        $orphans = array_diff($files, $paths);
        $files = File::query()
            ->whereIn('path', $orphans)
            ->get();

        if ($files->count() > 0) {
            Journal::info("CleanJob: {$library->name} {$files->count()} to delete.");
        }

        foreach ($files as $file) {
            $file->delete();
        }
    }

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
