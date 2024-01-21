<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\ParserJob;
use Illuminate\Console\Command;
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
    protected $signature = 'bookshelves:parse';

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

        ParserJob::dispatch();

        return Command::SUCCESS;
    }
}
