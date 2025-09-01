<?php

namespace App\Jobs\Clean;

use App\Enums\LibraryTypeEnum;
use App\Models\AudiobookTrack;
use App\Models\Book;
use App\Models\Library;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Kiwilan\LaravelNotifier\Facades\Journal;

class CleanAudiobookJob implements ShouldQueue
{
    use Batchable, Dispatchable, Queueable;

    public function __construct(
        protected ?int $limit = null,
        protected bool $fresh = false,
    ) {}

    public function handle(): void
    {
        Journal::info('AudiobookCleanJob: cleaning up audiobook files...');
        Library::where('type', LibraryTypeEnum::audiobook)->each(fn ($library) => $this->parse($library));
    }

    private function parse(Library $library)
    {
        $groups = AudiobookTrack::select('slug', DB::raw('COUNT(*) as track_count'))
            ->where('library_id', $library->id)
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
            if (count($book_ids) === 1) {
                continue;
            }

            $i++;
            $this->handleMultipleBookIds($tracks);
        }

        Book::where('is_audiobook', true)
            ->where('library_id', $library->id)
            ->doesntHave('audiobookTracks')
            ->get()
            ->each(fn (Book $book) => $book->delete());
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
                $track->book()->disassociate();
                $track->book()->associate($main_book);
                $track->saveQuietly();
            }
        }
    }
}
