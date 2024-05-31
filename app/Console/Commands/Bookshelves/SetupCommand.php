<?php

namespace App\Console\Commands\Bookshelves;

use App\Facades\Bookshelves;
use App\Models\Library;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Commands\Commandable;
use Kiwilan\Steward\Commands\Jobs\JobsClearCommand;
use Kiwilan\Steward\Commands\Log\LogClearCommand;
use Kiwilan\Steward\Services\DirectoryService;

/**
 * Main command of Bookshelves to generate Books with relations.
 */
class SetupCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:setup
                            {--f|fresh : Fresh install}
                            {--l|limit= : Limit of books to parse}';

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
        public bool $fresh = false,
        public ?int $limit = null,
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

        $this->fresh = $this->option('fresh');
        $this->limit = $this->optionInt('limit');

        if ($this->fresh) {
            $this->clear();
            $this->genres();
        }

        DirectoryService::make()->clearDirectory(Library::getJsonDirectory());

        $this->call(ParseCommand::class, [
            '--limit' => $this->limit,
        ]);

        $this->call(BooksCommand::class, [
            '--fresh' => $this->fresh,
        ]);

        return Command::SUCCESS;
    }

    private function clear(): void
    {
        $this->call(JobsClearCommand::class);

        $this->call('migrate:fresh', ['--seed' => true, '--force' => true]);
        $this->comment('Database reset!');

        $this->call(LogClearCommand::class);

        DirectoryService::make()->clearDirectory(storage_path('app/cache'));
        DirectoryService::make()->clearDirectory(storage_path('app/data'));
        DirectoryService::make()->clearDirectory(storage_path('app/debug'));
        File::deleteDirectory(storage_path('app/public'));

        $path = Bookshelves::exceptionParserLog();
        File::put($path, json_encode([]));

        $this->newLine();
        $this->info('Fresh mode enabled, reset database.');
        Journal::info('Fresh mode enabled, reset database.');

        $this->newLine();
    }

    private function genres(): void
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
