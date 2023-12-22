<?php

namespace App\Console\Commands\Bookshelves;

use App\Engines\Book\BookFileReader;
use App\Engines\Book\BookFilesReader;
use App\Enums\BookFormatEnum;
use App\Enums\MediaDiskEnum;
use App\Jobs\BookParserProcess;
use App\Jobs\BookRelationsParserProcess;
use App\Models\Book;
use App\Models\MediaExtended;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Kiwilan\Steward\Commands\Commandable;
use Spatie\Tags\Tag;

/**
 * Main command of Bookshelves to generate Books with relations.
 */
class MakeCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:make
                            {--f|fresh : reset current books and relation, keep users}
                            {--l|limit= : limit epub files to generate, useful for debug}
                            {--D|default : use default cover for all (skip covers step)}
                            {--F|force : skip confirm in prod}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Book model with all relationships, generate covers with different dimensions.';

    /** @var BookFileReader[] */
    protected array $files = [];

    /** @var string[] */
    protected array $books = [];

    /**
     * Create a new command instance.
     */
    public function __construct(
        protected bool $verbose = false,
        protected bool $default = false,
        protected bool $force = false,
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
        $this->title(description: 'Books & relations');

        $this->setupOptions();

        $this->comment('Files detected: '.count($this->files));
        $this->info('- Generate Book model with relationships: Author, Tag, Publisher, Language, Serie');
        $this->info('- Generate new EPUB file with standard name');
        $this->newLine();

        if (! $this->default) {
            $format = config('bookshelves.cover_extension');
            $this->comment('Generate covers for books (--default|-D to skip)');
            $this->info('- Generate covers with differents dimensions');
            $this->info("- Main format: {$format} (original from EPUB, thumbnail)");
            $this->info('- OpenGraph, Simple format: JPG (social, Catalog)');

            if (config('app.env') === 'local') {
                $this->info('You are in local, conversions are generate only in production');
            }
            $this->newLine();
        }

        $this->setGenres();

        $start = microtime(true);

        $this->books = Book::all()
            ->map(fn (Book $book) => $book->physical_path)
            ->toArray();

        $bar = $this->output->createProgressBar(count($this->files));
        $bar->start();

        foreach ($this->files as $file) {
            $this->convert($file);

            if (! $this->verbose) {
                $bar->advance();
            }
        }
        $bar->finish();
        $this->newLine();

        $this->parseRelations();

        $this->newLine();
        $time_elapsed_secs = number_format(microtime(true) - $start, 2);
        $this->info("Time in seconds: {$time_elapsed_secs}");

        return Command::SUCCESS;
    }

    private function setupOptions()
    {
        $this->force = $this->option('force') ?: false;
        $limit = str_replace('=', '', $this->option('limit'));
        $this->limit = intval($limit);
        $this->fresh = $this->option('fresh') ?: false;
        $this->verbose = $this->option('verbose') ?: false;
        $this->default = $this->option('default') ?: false;

        $this->askOnProduction();

        Artisan::call('clear:all', [], $this->getOutput());
        $parser = BookFilesReader::make(limit: $this->limit);
        $this->files = $parser->items();

        if ($this->fresh) {
            MediaExtended::query()->where('collection_name', MediaDiskEnum::cover)->delete();

            foreach (BookFormatEnum::toArray() as $format) {
                MediaExtended::query()->where('collection_name', $format)->delete();
            }
            File::deleteDirectory(public_path('storage/media/covers'));
            File::deleteDirectory(public_path('storage/media/formats'));
            Artisan::call('database', [
                '--books' => $this->fresh,
            ], $this->getOutput());
        }

        if (! $this->files) {
            $this->alert('No files detected!');

            return Command::FAILURE;
        }
    }

    private function setGenres()
    {
        $genres = config('bookshelves.tags.genres_list');

        foreach ($genres as $genre) {
            Tag::findOrCreate($genre, 'genre');
        }
    }

    private function convert(BookFileReader $file): void
    {
        if ($this->fresh) {
            BookParserProcess::dispatch($file, $this->verbose, $this->default);

            return;
        }

        if (! in_array($file->path(), $this->books, true)) {
            BookParserProcess::dispatch($file, $this->verbose, $this->default);
        }
    }

    private function parseRelations()
    {
        BookRelationsParserProcess::dispatch();
    }
}
