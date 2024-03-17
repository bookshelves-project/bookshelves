<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\AudiobookJob;
use App\Models\Audiobook;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

class AudiobooksCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:audiobooks
                            {--f|fresh : reset audiobooks}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create books from audiobooks.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->title();

        $fresh = $this->option('fresh') ?: false;

        $series = Audiobook::all()
            ->map(fn (Audiobook $audiobook) => $audiobook->serie)
            ->unique()
            ->values();

        foreach ($series as $serie) {
            AudiobookJob::dispatch($serie, $fresh);
        }
    }
}
