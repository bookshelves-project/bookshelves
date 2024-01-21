<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\SerieJob;
use App\Models\Serie;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

class SeriesCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:series
                            {--f|fresh : reset series relations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Improve series.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->title();

        $fresh = $this->option('fresh') ?: false;

        $series = Serie::all();
        foreach ($series as $serie) {
            SerieJob::dispatch($serie, $fresh);
        }
    }
}
