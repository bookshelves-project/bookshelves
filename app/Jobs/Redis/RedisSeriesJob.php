<?php

namespace App\Jobs\Book;

use App\Models\AudiobookTrack;
use App\Models\Serie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

/**
 * Parse `AudiobookTrack` to get all tracks with same `slug` and group them.
 */
class RedisSeriesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $library,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // 1️⃣ Identifier les slugs en doublon
        $duplicateSlugs = Serie::select('slug', DB::raw('COUNT(*) as serie_count'))
            ->groupBy('slug')
            ->having('serie_count', '>', 1)
            ->pluck('slug');

        DB::transaction(function () use ($duplicateSlugs) {
            foreach ($duplicateSlugs as $slug) {
                // Récupère toutes les Series pour ce slug
                $series = Serie::where('slug', $slug)->get();

                // Choisir la première comme principale
                $mainSerie = $series->shift();

                foreach ($series as $duplicate) {
                    // 🔹 Rattache les Books HasMany à la Serie principale
                    foreach ($duplicate->books as $book) {
                        $book->serie_id = $mainSerie->id;
                        $book->save();
                    }

                    // 🔹 Rattache les Authors MorphToMany à la Serie principale
                    $authorIds = $duplicate->authors()->pluck('id')->toArray();
                    if (! empty($authorIds)) {
                        $mainSerie->authors()->syncWithoutDetaching($authorIds);
                    }

                    // 🔹 Supprime la Serie doublon
                    $duplicate->delete();
                }
            }
        });

        echo "Tous les doublons de Series ont été fusionnés avec leurs relations Books et Authors.\n";
    }
}
