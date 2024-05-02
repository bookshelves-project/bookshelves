<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\ParserJob;
use Illuminate\Console\Command;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Commands\Commandable;

/**
 * Main command of Bookshelves to generate Books with relations.
 */
class ParseCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:parse
                            {--l|limit= : limit epub files to generate, useful for debug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse library files and create JSON files.';

    /**
     * Create a new command instance.
     */
    public function __construct(
        protected ?int $limit = null,
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

        $this->limit = $this->optionInt('limit');

        Journal::info('ParseCommand: parsing files...');
        ParserJob::dispatch($this->limit);

        return Command::SUCCESS;
    }
}
