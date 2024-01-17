<?php

namespace App\Console\Commands\Bookshelves;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Kiwilan\Steward\Commands\Commandable;

/**
 * Main command of Bookshelves to generate Books with relations.
 */
class ParseCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:parse
                            {--f|fresh : reset current books and relation, keep users}
                            {--l|limit= : limit epub files to generate, useful for debug}';

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
        protected int $limit = 0,
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

        $limit = str_replace('=', '', $this->option('limit'));
        $this->limit = intval($limit);
        $this->fresh = $this->option('fresh') ?: false;

        if ($this->fresh) {
            Artisan::call('migrate:fresh', ['--seed' => true]);
        }

        $this->info('Parsing books...');
        Artisan::call(BooksCommand::class, [
            '--fresh' => $this->fresh,
            '--limit' => $this->limit,
        ]);
        $this->comment('Jobs dispatched!');
        $this->newLine();

        $this->info('Parsing authors...');
        Artisan::call(AuthorsCommand::class, [
            '--fresh' => $this->fresh,
        ]);
        $this->comment('Jobs dispatched!');
        $this->newLine();

        $this->info('Parsing series...');
        Artisan::call(SeriesCommand::class, [
            '--fresh' => $this->fresh,
        ]);
        $this->comment('Jobs dispatched!');
        $this->newLine();

        $this->info('Done!');

        return Command::SUCCESS;
    }
}
