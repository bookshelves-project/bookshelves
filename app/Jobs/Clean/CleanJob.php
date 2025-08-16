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
        foreach (Library::all() as $library) {
            $this->cleanBooks($library);
        }

        $this->audiobookFusion();
        $this->cleanAuthors();
        $this->cleanSeries();

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
        $duplicateGroups = AudiobookTrack::select('slug', 'library_id', DB::raw('COUNT(DISTINCT book_id) as book_count'))
            ->groupBy('slug', 'library_id')
            ->having('book_count', '>', 1)
            ->get();

        foreach ($duplicateGroups as $group) {
            DB::transaction(function () use ($group) {
                // Récupère tous les book_id pour ce groupe de tracks
                $bookIds = AudiobookTrack::where('slug', $group->slug)
                    ->where('library_id', $group->library_id)
                    ->pluck('book_id')
                    ->filter() // ignore les null
                    ->unique()
                    ->toArray();

                if (count($bookIds) < 2) {
                    return; // pas de doublon réel
                }

                // Collecte tous les AudiobookTrack liés
                $trackIds = AudiobookTrack::whereIn('book_id', $bookIds)->pluck('id')->toArray();

                // 2️⃣ Supprimer l'ancien lien Book pour les tracks
                AudiobookTrack::whereIn('id', $trackIds)->update(['book_id' => null]);

                // 3️⃣ Supprimer tous les Books doublons
                Book::whereIn('id', $bookIds)->delete();

                // 4️⃣ Créer un nouveau Book principal
                $newBook = Book::create([
                    'title' => $group->slug, // ou un autre titre selon ta logique
                    'slug' => $group->slug,
                    'library_id' => $group->library_id,
                ]);

                // 5️⃣ Réassocier tous les tracks au nouveau Book
                AudiobookTrack::whereIn('id', $trackIds)->update(['book_id' => $newBook->id]);
            });
        }

        echo "Post-traitement terminé : tous les Books doublons basés sur AudiobookTrack ont été fusionnés.\n";

        // Journal::info('All duplicate books have been merged.');
    }
}
