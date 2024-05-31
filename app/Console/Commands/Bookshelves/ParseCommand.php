<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\ParserWrapperJob;
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
                            {--f|fresh : Fresh install}
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
        protected bool $fresh = false,
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

        $this->fresh = $this->option('fresh');
        $this->limit = $this->optionInt('limit');

        Journal::info('ParseCommand: parsing files...');
        ParserWrapperJob::dispatch($this->fresh, $this->limit);

        return Command::SUCCESS;
    }
}
