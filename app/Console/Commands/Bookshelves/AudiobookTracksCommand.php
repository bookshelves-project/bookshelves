<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\AudiobookTrackJob;
use App\Models\AudiobookTrack;
use App\Models\Library;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Commands\Commandable;

class AudiobookTracksCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:audiobook-tracks
                            {library-slug : Library slug to parse}
                            {--f|fresh : Reset audiobooks tracks}';

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

        $librarySlug = (string) $this->argument('library-slug');
        $fresh = $this->option('fresh') ?: false;

        /** @var ?Library */
        $library = Library::query()->where('slug', $librarySlug)->first();
        if (! $library || ! $library->is_audiobook) {
            Journal::warning("AudiobookTracksCommand: no library found with slug {$librarySlug} or not an audiobook library");

            return;
        }

        $tracks = AudiobookTrack::query()
            ->where('library_id', $library->id)
            ->get()
            ->groupBy(['slug']);

        if ($tracks->isEmpty()) {
            Journal::warning("AudiobookTracksCommand: no tracks detected in {$library->name}");

            return;
        }

        foreach ($tracks as $audiobook) {
            AudiobookTrackJob::dispatch($audiobook, $library);
        }
    }
}
