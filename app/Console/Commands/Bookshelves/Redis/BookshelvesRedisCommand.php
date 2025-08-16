<?php

namespace App\Console\Commands\Bookshelves\Redis;

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
    protected $signature = 'bookshelves:redis
                            {--f|fresh : Fresh install}';

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
        public bool $fresh = false,
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

        $this->fresh = $this->option('fresh') ?: false;

        RedisAudiobooksJob::withChain([
            new RedisSeriesJob($this->fresh),
            new RedisAuthorsJob,
        ])->dispatch();

        return Command::SUCCESS;
    }
}
