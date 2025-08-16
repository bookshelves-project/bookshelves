<?php

namespace App\Console\Commands\Bookshelves;

use App\Enums\LibraryTypeEnum;
use App\Jobs\Redis\RedisAudiobooksJob;
use App\Jobs\Redis\RedisAuthorsJob;
use App\Jobs\Redis\RedisSeriesJob;
use App\Models\Library;
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
        // public bool $fresh = false,
        // public ?int $limit = null,
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

        Library::where('type', LibraryTypeEnum::audiobook)->get()->each(function (Library $library) {
            RedisAudiobooksJob::dispatch($library->id);
        });

        RedisAuthorsJob::dispatch();

        Library::all()->each(function (Library $library) {
            RedisSeriesJob::dispatch($library->id);
        });

        return Command::SUCCESS;
    }
}
