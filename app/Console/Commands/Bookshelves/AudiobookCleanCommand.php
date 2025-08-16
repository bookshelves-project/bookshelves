<?php

namespace App\Console\Commands\Bookshelves;

use App\Enums\LibraryTypeEnum;
use App\Facades\Bookshelves;
use App\Jobs\Book\AudiobookCleanJob;
use App\Models\Library;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

/**
 * Main command of Bookshelves to generate Books with relations.
 */
class AudiobookCleanCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:audiobook-clean';

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
            AudiobookCleanJob::dispatch($library->slug);
        });

        return Command::SUCCESS;
    }
}
