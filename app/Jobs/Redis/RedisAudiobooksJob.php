<?php

namespace App\Jobs\Redis;

use App\Models\AudiobookTrack;
use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Kiwilan\LaravelNotifier\Facades\Journal;

/**
 * Parse `AudiobookTrack` to get all tracks with same `slug` and group them.
 */
class RedisAudiobooksJob implements ShouldQueue
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
        Journal::info("RedisAudiobooksJob: starting for library {$this->library}...");

        $groups = AudiobookTrack::select('slug', DB::raw('COUNT(*) as track_count'))
            ->where('library_id', $this->library)
            ->groupBy('slug')
            ->having('track_count', '>', 1)
            ->get();

        $i = 0;
        foreach ($groups as $group) {
            $book_ids = [];
            $tracks = AudiobookTrack::where('slug', $group->slug)->get();

            foreach ($tracks as $track) {
                $book_ids[] = $track->book_id;
            }

            // Check if `book_ids` are same
            $book_ids = array_unique($book_ids);
            if (count($book_ids) !== 1) {
                $i++;
                $this->handleMultipleBookIds($tracks);
            }
        }

        Journal::debug("RedisAudiobooksJob: found {$i} groups with multiple book IDs");
        Journal::info("RedisAudiobooksJob: finished for library {$this->library}");
    }

    /**
     * Handle multiple book_ids for an audiobook.
     *
     * @param  Collection<int, AudiobookTrack>  $tracks
     */
    private function handleMultipleBookIds(Collection $tracks): void
    {
        $main_book = $tracks->first()->book_id;

        foreach ($tracks as $track) {
            if ($track->book_id !== $main_book) {
                $wrong_book = $track->book_id;

                $track->book()->dissociate();
                $track->book()->associate($main_book);
                $track->saveQuietly();

                Book::find($wrong_book)?->delete();
            }
        }
    }
}
