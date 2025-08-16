<?php

namespace App\Console\Commands\Bookshelves;

use App\Enums\LibraryTypeEnum;
use App\Jobs\Book\RedisAudiobooksJob;
use App\Jobs\Book\RedisAuthorsJob;
use App\Jobs\Book\RedisSeriesJob;
use App\Models\Library;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

class RedisCleanCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:redis-clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean Audiobooks metadata and check relations.';

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
            RedisAudiobooksJob::dispatch($library->slug);
        });

        RedisAuthorsJob::dispatch();
        RedisSeriesJob::dispatch();

        return Command::SUCCESS;
    }
}
