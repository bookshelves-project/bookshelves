<?php

namespace App\Console\Commands\Bookshelves;

use App\Facades\Bookshelves;
use App\Jobs\BookWrapperJob;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

/**
 * Main command of Bookshelves to generate Books with relations.
 */
class BooksCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:books
                            {--f|fresh : reset current books and relation, keep users}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Book with Author, Tag, Publisher, Language, Serie and cover.';

    /**
     * Create a new command instance.
     */
    public function __construct(
        protected bool $fresh = false,
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

        BookWrapperJob::dispatch($this->fresh);

        return Command::SUCCESS;
    }
}
