<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\Clean\CleanJob;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

/**
 * Main command of Bookshelves to generate Books with relations.
 */
class CleanCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean Bookshelves data.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->title();

        CleanJob::dispatch();

        return Command::SUCCESS;
    }
}
