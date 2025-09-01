<?php

namespace App\Console\Commands\Bookshelves;

use App\Engines\BookshelvesUtils;
use App\Engines\Library\LibraryScanner;
use App\Facades\Bookshelves;
use App\Jobs\AnalyzeJob;
use App\Models\Library;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;
use Kiwilan\Steward\Commands\Model\ModelBackupCommand;
use Kiwilan\Steward\Commands\Model\ModelRestoreCommand;

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
                            {--m|monitor : only monitor files to get their status}
                            {--f|fresh : fresh install, to delete all files and re-create them}
                            {--l|limit= : Limit epub files to generate, useful for debug}';

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

        $this->monitor = $this->optionBool('monitor');
        $this->fresh = $this->optionBool('fresh');
        $this->limit = $this->optionInt('limit') ?: null;

        $this->comment('Fresh: '.($this->fresh ? 'yes' : 'no'));
        $this->comment('Limit: '.($this->limit ?: 'no limit'));
        $this->comment('Queue: '.config('queue.default'));
        if (config('queue.default') === 'redis') {
            $this->comment(' Redis processes: '.config('horizon.environments.production.supervisor-1.maxProcesses'));
        }
        $this->newLine();

        if ($this->fresh) {
            $this->comment('Fresh install: deleting all files...');
            $this->clearFresh();
        }

        BookshelvesUtils::clearCache();
        AnalyzeJob::dispatch($this->limit, $this->fresh);

        return Command::SUCCESS;
    }

    private function clearFresh(): void
    {
        // $this->call(JobsClearCommand::class);

        $this->call(ModelBackupCommand::class, [
            'model' => 'App\Models\User',
        ]);

        $this->call('migrate:fresh', ['--seed' => true, '--force' => true]);
        $this->comment('Database reset!');

        $this->call(ModelRestoreCommand::class, [
            'model' => 'App\Models\User',
        ]);

        // $this->call(LogClearCommand::class);

        $path = Bookshelves::exceptionParserLog();
        // File::put($path, json_encode([]));
        Library::cacheClear();
        // CleanCoversJob::dispatch();

        $this->call('db:seed', [
            '--class' => 'EmptySeeder',
            '--force' => true,
        ]);

        $this->newLine();
    }

    // private function monitor(Library $library): void
    // {
    //     $verbose = $this->option('verbose');

    //     $this->line("Scanning library: {$library->name}...");
    //     $scanner = LibraryScanner::make($library, $this->limit);

    //     if (! $scanner->isValid()) {
    //         $this->error("Library {$library->name} with path `{$library->path}` is not valid.");

    //         return;
    //     }

    //     if ($verbose) {
    //         $this->newLine();
    //         $this->table(
    //             ['Path'],
    //             array_map(fn ($item) => [strlen($item) > 80 ? substr($item, 0, 77).'...' : $item], $scanner->getFilePaths())
    //         );
    //         $this->newLine();
    //     }

    //     $this->comment("Found {$scanner->getCount()} files in library {$library->name}.");
    //     $this->line('Library scanned.');
    //     $this->newLine();
    // }
}
