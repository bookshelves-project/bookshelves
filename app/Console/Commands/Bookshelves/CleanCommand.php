<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\CleanJob;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

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
    protected $description = 'Clean books.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->title();

        CleanJob::dispatch();
    }
}
