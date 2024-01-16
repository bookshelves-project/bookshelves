<?php

namespace App\Console\Commands\Bookshelves;

use App\Engines\Book\BookFileItem;
use App\Engines\Book\BookFileScanner;
use App\Jobs\BookParserProcess;
use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Serie;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Kiwilan\Steward\Commands\Commandable;
use Kiwilan\Steward\Commands\Jobs\JobsClearCommand;
use Kiwilan\Steward\Commands\Log\LogClearCommand;
use Kiwilan\Steward\Services\DirectoryService;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
                            {--l|limit= : limit epub files to generate, useful for debug}
                            {--D|default : use default cover for all (skip covers step)}
                            {--F|force : skip confirm in prod}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Book with Author, Tag, Publisher, Language, Serie and cover.';

    /**
     * Create a new command instance.
     *
     * @param  BookFileItem[]  $files
     */
    public function __construct(
        protected bool $force = false,
        protected bool $fresh = false,
        protected int $limit = 0,
        protected array $files = [],
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

        $this->force = $this->option('force') ?: false;
        $limit = str_replace('=', '', $this->option('limit'));
        $this->limit = intval($limit);
        $this->fresh = $this->option('fresh') ?: false;

        $this->askOnProduction();

        if ($this->fresh) {
            $this->clear();
        }

        $this->info('Scanning books...');
        $parser = BookFileScanner::make(limit: $this->limit);
        $this->files = $parser->items();

        if (! $this->files) {
            $msg = 'No files detected!';
            $this->alert($msg);
            Log::warning($msg);

            return Command::FAILURE;
        }

        $count = count($this->files);
        $msg = "Files detected: {$count}";
        $this->comment($msg);
        Log::info($msg);

        $this->setGenres();

        $current_books = Book::all()
            ->map(fn (Book $book) => $book->physical_path)
            ->toArray();

        $this->newLine();
        $bar = $this->output->createProgressBar($count);
        $bar->start();
        $i = 0;

        foreach ($this->files as $file) {
            $i++;
            if (! $this->fresh && in_array($file->path(), $current_books, true)) {
                $bar->advance();

                continue;
            }

            BookParserProcess::dispatch($file, "{$i}/{$count}");
            $bar->advance();
        }
        $bar->finish();
        $this->newLine(2);

        $this->info('Done!');

        return Command::SUCCESS;
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

    private function clear(): void
    {
        $msg = 'Fresh mode enabled, delete books, relations and jobs.';
        $this->info($msg);
        Log::info($msg);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Author::query()->truncate();
        Serie::query()->truncate();
        Book::query()->truncate();
        Tag::query()->truncate();
        Language::query()->truncate();
        Publisher::query()->truncate();
        Media::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Artisan::call(JobsClearCommand::class);
        Artisan::call(LogClearCommand::class);
        DirectoryService::make()->clearDirectory(storage_path('app/cache'));
        File::deleteDirectory(storage_path('app/public'));

        $this->newLine();
    }
}
