<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\AudiobookTrackJob;
use App\Models\AudiobookTrack;
use Illuminate\Console\Command;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Commands\Commandable;

class AudiobookTracksCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:audiobooks-tracks
                            {--f|fresh : reset audiobooks tracks}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create books from audiobooks tracks.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->title();

        $fresh = $this->option('fresh') ?: false;

        $books = AudiobookTrack::all()
            ->map(fn (AudiobookTrack $track) => $track->title)
            ->unique()
            ->values();

        if ($books->isEmpty()) {
            Journal::warning('AudiobookTracksCommand: no tracks detected');

            return;
        }

        foreach ($books as $book) {
            AudiobookTrackJob::dispatch($book, $fresh);
        }
    }
}
