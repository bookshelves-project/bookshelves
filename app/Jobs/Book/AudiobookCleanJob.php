<?php

namespace App\Jobs\Book;

use App\Models\AudiobookTrack;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Kiwilan\LaravelNotifier\Facades\Journal;

class AudiobookCleanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $library,
        protected bool $fresh = false,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // parse AudiobookTrack to get all tracks with same `slug` and group them
        $groups = AudiobookTrack::select('slug', DB::raw('COUNT(*) as track_count'))
            ->groupBy('slug')
            ->having('track_count', '>', 1)
            ->get();

        foreach ($groups as $group) {
            $book_ids = [];

            $tracks = AudiobookTrack::where('slug', $group->slug)->get();
            Journal::debug('tracks of '.$group->slug, [
                'id' => $tracks->pluck('id')->toArray(),
                'slug' => $tracks->pluck('slug')->toArray(),
            ]);

            foreach ($tracks as $track) {
                $book_ids[] = $track->book_id;
            }

            // Check if `book_ids` are same
            $book_ids = array_unique($book_ids);
            if (count($book_ids) === 1) {
                Journal::debug('single book_id for '.$group->slug, [
                    'book_id' => $book_ids[0],
                ]);
            } else {
                Journal::error('multiple book_ids for '.$group->slug, [
                    'book_ids' => $book_ids,
                ]);
            }
        }
    }
}
