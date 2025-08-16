<?php

namespace App\Jobs\Redis;

use App\Models\Author;
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
        Journal::info('RedisAuthorsJob: starting...');

        // Identify duplicate slugs
        $duplicateSlugs = Author::select('slug', DB::raw('COUNT(*) as author_count'))
            ->groupBy('slug')
            ->having('author_count', '>', 1)
            ->pluck('slug');

        DB::transaction(function () use ($duplicateSlugs) {
            $i = 0;
            foreach ($duplicateSlugs as $slug) {
                // Get all authors with this slug
                $authors = Author::where('slug', $slug)->get();

                // Choose the first as main
                $mainAuthor = $authors->shift();

                foreach ($authors as $duplicate) {
                    $i++;
                    // Attach Books (MorphToMany)
                    $bookIds = $duplicate->books()->pluck('id')->toArray();
                    if (! empty($bookIds)) {
                        $mainAuthor->books()->syncWithoutDetaching($bookIds);
                    }

                    // Attach Series (MorphToMany)
                    $serieIds = $duplicate->series()->pluck('id')->toArray();
                    if (! empty($serieIds)) {
                        $mainAuthor->series()->syncWithoutDetaching($serieIds);
                    }

                    // Delete duplicate author
                    $duplicate->delete();
                }
            }

            Journal::debug("RedisAuthorsJob: found {$i} duplicate authors");
        });

        Journal::info('RedisAuthorsJob: finished');
    }
}
