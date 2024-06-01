<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\Book\AudiobookBookDispatchJob;
use Kiwilan\Steward\Commands\Commandable;

class AudiobooksCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:audiobooks
                            {library-slug : Library slug to parse}';

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

        AudiobookBookDispatchJob::dispatch($librarySlug);
    }
}
