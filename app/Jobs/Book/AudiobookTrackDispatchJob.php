<?php

namespace App\Jobs\Book;

use App\Models\AudiobookTrack;
use App\Models\Library;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\LaravelNotifier\Facades\Journal;

class AudiobookTrackDispatchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $librarySlug,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var ?Library */
        $library = Library::query()->where('slug', $this->librarySlug)->first();
        if (! $library || ! $library->is_audiobook) {
            Journal::warning("AudiobookTracksCommand: no library found with slug {$this->librarySlug} or not an audiobook library");

            return;
        }

        $tracks = AudiobookTrack::query()
            ->where('library_id', $library->id)
            ->where('book_id', null)
            ->get()
            ->groupBy(['slug']);

        if ($tracks->isEmpty()) {
            Journal::debug("AudiobookTracksCommand: no new tracks detected in {$library->name}");

            return;
        }

        foreach ($tracks as $audiobook) {
            AudiobookTrackJob::dispatch($audiobook, $library);
        }
    }
}
