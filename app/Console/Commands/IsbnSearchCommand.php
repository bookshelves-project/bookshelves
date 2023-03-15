<?php

namespace App\Console\Commands;

use App\Engines\IsbnEngine;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\CommandSteward;

class IsbnSearchCommand extends CommandSteward
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'isbn:search {isbn}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search about ISBN on the web.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Example: `isbn:search 9782075038362`
        $this->title();

        $isbn = $this->argument('isbn');

        if (! $isbn) {
            $this->error('No ISBN provided.');

            return Command::FAILURE;
        }

        $this->info("Searching for ISBN: {$isbn}");

        IsbnEngine::make($isbn);

        // TODO

        $this->newLine();
        $this->info('Done!');

        return Command::SUCCESS;
    }
}
