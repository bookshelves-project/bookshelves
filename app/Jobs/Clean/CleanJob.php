<?php

namespace App\Jobs\Clean;

use App\Models\AudiobookTrack;
use App\Models\Author;
use App\Models\Book;
use App\Models\File;
use App\Models\Library;
use App\Models\Serie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
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
        Journal::debug('CleanJob: clean books, audiobooks, authors and series...');

        foreach (Library::all() as $library) {
            $this->cleanBooks($library);
        }

        $this->audiobookFusion();
        $this->cleanAuthors();
        $this->cleanSeries();

        Artisan::call('scout:fresh');

        DirectoryService::make()->clearDirectory(storage_path('app/cache'));
    }

    /**
     * Clean Books with orphaned files.
     */
    private function cleanBooks(Library $library)
    {
        if (! file_exists($library->getJsonPath())) {
            Journal::error("CleanJob: {$library->name} library json file not found", [
                'path' => $library->getJsonPath(),
            ]);

            return;
        }

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

    private function audiobookFusion(): void
    {
        // 1️⃣ Identifier les slugs + library_id qui ont plusieurs book_id
        /** @var \Illuminate\Database\Eloquent\Collection<int, AudiobookTrack> $duplicates */
        $duplicates = AudiobookTrack::select('slug', 'library_id', DB::raw('COUNT(DISTINCT book_id) as book_count'))
            ->groupBy('slug', 'library_id')
            ->having('book_count', '>', 1)
            ->get();

        foreach ($duplicates as $duplicate) {
            DB::transaction(function () use ($duplicate) {
                // Récupère tous les book_id pour ce groupe de tracks
                $bookIds = AudiobookTrack::where('slug', $duplicate->slug)
                    ->where('library_id', $duplicate->library_id)
                    ->pluck('book_id')
                    ->filter() // ignore les null
                    ->unique()
                    ->toArray();

                if (count($bookIds) < 2) {
                    Journal::debug("CleanJob: No duplicates found for slug {$duplicate->slug} in library {$duplicate->library_id}");

                    return; // pas de doublon réel
                }

                // Collecte tous les AudiobookTrack liés
                $trackIds = AudiobookTrack::whereIn('book_id', $bookIds)->pluck('id')->toArray();

                // 2️⃣ Supprimer l'ancien lien Book pour les tracks
                AudiobookTrack::whereIn('id', $trackIds)->update(['book_id' => null]);

                // 3️⃣ Supprimer tous les Books doublons
                Book::whereIn('id', $bookIds)->delete();

                Journal::info("CleanJob: Merged audiobooks for slug {$duplicate->slug} in library {$duplicate->library_id}", [
                    'duplicate' => $duplicate,
                    'count' => count($trackIds),
                ]);

                // 4️⃣ Créer un nouveau Book principal
                $newBook = new Book([
                    'title' => $duplicate->title,
                    'slug' => $duplicate->slug,
                    'library_id' => $duplicate->library_id,
                ]);

                // 5️⃣ Réassocier tous les tracks au nouveau Book
                AudiobookTrack::whereIn('id', $trackIds)->update(['book_id' => $newBook->id]);
            });
        }

        Journal::info('All duplicate audiobooks have been merged.');
    }
}
