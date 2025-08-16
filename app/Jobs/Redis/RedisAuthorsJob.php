<?php

namespace App\Jobs\Book;

use App\Models\AudiobookTrack;
use App\Models\Author;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

/**
 * Parse `AudiobookTrack` to get all tracks with same `slug` and group them.
 */
class RedisAuthorsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // 1️⃣ Identifier les slugs en doublon
        $duplicateSlugs = Author::select('slug', DB::raw('COUNT(*) as author_count'))
            ->groupBy('slug')
            ->having('author_count', '>', 1)
            ->pluck('slug');

        DB::transaction(function () use ($duplicateSlugs) {
            foreach ($duplicateSlugs as $slug) {
                // Récupère tous les auteurs avec ce slug
                $authors = Author::where('slug', $slug)->get();

                // Choisis le premier comme principal
                $mainAuthor = $authors->shift();

                foreach ($authors as $duplicate) {
                    // 🔹 Rattache les Books (MorphToMany)
                    $bookIds = $duplicate->books()->pluck('id')->toArray();
                    if (! empty($bookIds)) {
                        $mainAuthor->books()->syncWithoutDetaching($bookIds);
                    }

                    // 🔹 Rattache les Series (MorphToMany)
                    $serieIds = $duplicate->series()->pluck('id')->toArray();
                    if (! empty($serieIds)) {
                        $mainAuthor->series()->syncWithoutDetaching($serieIds);
                    }

                    // 🔹 Supprime l'auteur doublon
                    $duplicate->delete();
                }
            }
        });

        echo "Tous les doublons d'Author ont été fusionnés avec leurs relations Books et Series.\n";
    }
}
