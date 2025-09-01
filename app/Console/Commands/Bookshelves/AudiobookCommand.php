<?php

namespace App\Console\Commands\Bookshelves;

use App\Facades\Bookshelves;
use App\Jobs\Clean\CleanAudiobookJob;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

/**
 * Main command of Bookshelves to generate Books with relations.
 */
class AudiobookCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:audiobook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan libraries and create `File`, to get only count use `--m|monitor`';

    /**
     * Create a new command instance.
     */
    public function __construct(
        protected bool $monitor = false,
        protected bool $fresh = false,
        protected ?int $limit = null,
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

        CleanAudiobookJob::dispatch();

        return Command::SUCCESS;
    }
}
