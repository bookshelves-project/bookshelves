<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\Redis\RedisAudiobooksJob;
use App\Jobs\Redis\RedisAuthorsJob;
use App\Jobs\Redis\RedisSeriesJob;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

class BookshelvesRedisCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:redis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Redis clean-up for audiobooks, authors, and series.';

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

        RedisAudiobooksJob::withChain([
            new RedisSeriesJob,
            new RedisAuthorsJob,
        ])->dispatch();

        return Command::SUCCESS;
    }
}
