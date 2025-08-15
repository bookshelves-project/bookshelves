<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\Author\AuthorsDispatchJob;
use Illuminate\Console\Command;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Commands\Commandable;

/**
 * Main command of Bookshelves to generate Books with relations.
 */
class AuthorsCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:authors
                            {--f|fresh : Fresh parsing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse authors to add metadata.';

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

        $msg = 'Parse Authors to add metadata';
        Journal::info($msg);
        $this->info($msg);

        AuthorsDispatchJob::dispatch($this->fresh);

        return Command::SUCCESS;
    }
}
