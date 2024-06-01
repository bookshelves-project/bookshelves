<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\Book\AudiobookTrackDispatchJob;
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

        AudiobookTrackDispatchJob::dispatch($librarySlug);
    }
}
