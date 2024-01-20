<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\SerieWrapperJob;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

class GoogleBooksCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:google-books';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Improves books with Google Books data.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->title();

        SerieWrapperJob::dispatch();
    }
}
