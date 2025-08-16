<?php

namespace App\Console\Commands\Bookshelves;

use App\Facades\Bookshelves;
use App\Jobs\Clean\CleanCoversJob;
use App\Jobs\Clean\CleanJsonJob;
use App\Models\Library;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Commands\Commandable;
use Kiwilan\Steward\Commands\Jobs\JobsClearCommand;
use Kiwilan\Steward\Commands\Log\LogClearCommand;
use Kiwilan\Steward\Commands\Model\ModelBackupCommand;
use Kiwilan\Steward\Commands\Model\ModelRestoreCommand;
use Kiwilan\Steward\Services\DirectoryService;

/**
 * Main command of Bookshelves to generate Books with relations.
 */
class AnalyzeCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:analyze
                            {--f|fresh : Fresh install}
                            {--l|limit= : Limit of books to parse}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute `bookshelves:library` for each library, with fresh install option to reset database.';

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

        $this->fresh = $this->option('fresh') ?: false;
        $this->limit = $this->optionInt('limit') ?: null;

        $this->comment('Fresh: '.($this->fresh ? 'yes' : 'no'));
        $this->comment('Limit: '.($this->limit ?: 'no limit'));
        $this->newLine();
        $this->comment('Queue: '.config('queue.default'));
        $this->comment('Horizon: '.config('horizon.environments.local.supervisor-1.maxProcesses'));
        $this->newLine();

        if ($this->fresh) {
            $this->info('Clear database... (fresh mode)');
            $this->clear();
            $this->newLine();

            $this->info('Create genres... (fresh mode)');
            $this->genres();
            $this->newLine();
        }

        CleanJsonJob::dispatch();

        $msg = 'Analyze libraries...';
        Journal::info($msg)->toDatabase();
        $this->info($msg);

        foreach (Library::inOrder() as $library) {
            $this->call(LibraryCommand::class, [
                'library-slug' => $library->slug,
                '--fresh' => $this->fresh,
                '--limit' => $this->limit,
            ]);
        }
        $this->newLine();

        if ($this->fresh) {
            Artisan::call('optimize:fresh');
        }

        return Command::SUCCESS;
    }

    private function clear(): void
    {
        $this->call(JobsClearCommand::class);

        $this->call(ModelBackupCommand::class, [
            'model' => 'App\Models\User',
        ]);

        $this->call('migrate:fresh', ['--seed' => true, '--force' => true]);
        $this->comment('Database reset!');

        $this->call(ModelRestoreCommand::class, [
            'model' => 'App\Models\User',
        ]);

        $this->call(LogClearCommand::class);

        DirectoryService::make()->clearDirectory(storage_path('app/cache'));
        DirectoryService::make()->clearDirectory(storage_path('app/data'));
        DirectoryService::make()->clearDirectory(storage_path('app/debug'));
        File::deleteDirectory(storage_path('app/public'));

        $path = Bookshelves::exceptionParserLog();
        File::put($path, json_encode([]));
        Library::cacheClear();
        CleanCoversJob::dispatch();

        $this->call('db:seed', [
            '--class' => 'EmptySeeder',
            '--force' => true,
        ]);

        $this->newLine();
    }

    private function genres(): void
    {
        /** @var string[] */
        $genres = config('bookshelves.tags.genres_list');

        foreach ($genres as $genre) {
            Tag::query()->firstOrCreate([
                'name' => $genre,
                'type' => 'genre',
            ]);
        }
    }
}
