<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\Serie\SeriesDispatchJob;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

/**
 * Main command of Bookshelves to generate Books with relations.
 */
class SeriesCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:series
                            {--f|fresh : Fresh parsing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse series to add metadata.';

    /**
     * Create a new command instance.
     */
    public function __construct(
        protected bool $fresh = false,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->title();

        $this->fresh = $this->option('fresh');

        SeriesDispatchJob::dispatch($this->fresh);
        $this->call(CleanCommand::class);
        $this->call(ScoutResetCommand::class);

        return Command::SUCCESS;
    }
}
