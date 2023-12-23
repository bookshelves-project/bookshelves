<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\BookRelationsParserProcess;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

class RelationsCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:relations
                            {--f|fresh : reset relations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse authors and series relations.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->title();

        BookRelationsParserProcess::dispatch();
    }
}
