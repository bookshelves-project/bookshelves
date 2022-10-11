<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kiwilan\Steward\Console\CommandProd;

class IsbnSearchCommand extends CommandProd
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
        $this->intro();

        $isbn = $this->argument('isbn');
        if (! $isbn) {
            $this->error('No ISBN provided.');
            return Command::FAILURE;
        }

        $this->info("Searching for ISBN: {$isbn}");

        return Command::SUCCESS;
    }
}
