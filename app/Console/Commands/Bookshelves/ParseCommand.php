<?php

namespace App\Console\Commands\Bookshelves;

use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Kiwilan\Steward\Commands\Commandable;
use Kiwilan\Steward\Commands\Jobs\JobsClearCommand;
use Kiwilan\Steward\Commands\Log\LogClearCommand;
use Kiwilan\Steward\Services\DirectoryService;

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
            $this->clear();
            $this->setGenres();
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

    private function clear(): void
    {
        $msg = 'Fresh mode enabled, reset database.';
        $this->info($msg);
        Log::info($msg);

        Artisan::call('migrate:fresh', ['--seed' => true]);
        $this->comment('Database reset!');

        Artisan::call(JobsClearCommand::class);
        Artisan::call(LogClearCommand::class);
        DirectoryService::make()->clearDirectory(storage_path('app/cache'));
        File::deleteDirectory(storage_path('app/public'));

        $this->newLine();
    }

    private function setGenres(): void
    {
        $genres = config('bookshelves.tags.genres_list');

        foreach ($genres as $genre) {
            Tag::query()->firstOrCreate([
                'name' => $genre,
                'type' => 'genre',
            ]);
        }
    }
}
