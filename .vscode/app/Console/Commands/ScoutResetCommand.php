<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\Clean\ScoutJob;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

/**
 * Main command of Bookshelves to generate Books with relations.
 */
class ScoutResetCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:scout-reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Scout data.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->title();

        ScoutJob::dispatch();

        return Command::SUCCESS;
    }
}
