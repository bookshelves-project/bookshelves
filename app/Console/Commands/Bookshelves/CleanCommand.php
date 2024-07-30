<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\Clean\CleanAllJob;
use App\Jobs\Clean\CleanJob;
use Illuminate\Console\Command;
use Kiwilan\LaravelNotifier\Facades\Journal;
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
    protected $signature = 'bookshelves:clean
                            {--a|all : Clean all data}';

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

        $all = $this->optionBool('all', false);

        $msg = 'Clean Bookshelves...';
        Journal::info($msg);
        $this->info($msg);

        if ($all) {
            CleanAllJob::dispatch();
        } else {
            CleanJob::dispatch();
        }

        return Command::SUCCESS;
    }
}
