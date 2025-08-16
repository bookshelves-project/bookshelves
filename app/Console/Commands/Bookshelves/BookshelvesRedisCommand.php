<?php

namespace App\Console\Commands\Bookshelves;

use App\Enums\LibraryTypeEnum;
use App\Jobs\Redis\RedisAudiobooksJob;
use App\Jobs\Redis\RedisAuthorsJob;
use App\Jobs\Redis\RedisSeriesJob;
use App\Models\Library;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
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

        $batch = Bus::batch([
            Library::where('type', LibraryTypeEnum::audiobook)->get()->each(function (Library $library) {
                RedisAudiobooksJob::dispatch($library->id);
            }),
        ])->then(function () {
            Library::all()->each(function (Library $library) {
                RedisSeriesJob::dispatch($library->id);
            });
        })->then(function () {
            RedisAuthorsJob::dispatch();
        })->dispatch();

        return Command::SUCCESS;
    }
}
