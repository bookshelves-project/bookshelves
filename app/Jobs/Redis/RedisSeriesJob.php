<?php

namespace App\Jobs\Redis;

use App\Models\Serie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Kiwilan\LaravelNotifier\Facades\Journal;

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
        protected string|int $library,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Journal::info("RedisSeriesJob: starting for library {$this->library}...");

        // Identify duplicate slugs
        $duplicateSlugs = Serie::select('slug', DB::raw('COUNT(*) as serie_count'))
            ->where('library_id', $this->library)
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

        Journal::info("RedisSeriesJob: finished for library: {$this->library}");
    }
}
