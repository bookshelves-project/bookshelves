<?php

namespace App\Console\Commands\Bookshelves;

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

        $msg = 'Clean Bookshelves...';
        Journal::info($msg);
        $this->info($msg);

        CleanJob::dispatch();

        return Command::SUCCESS;
    }
}
