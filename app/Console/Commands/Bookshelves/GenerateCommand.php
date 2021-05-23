<?php

namespace App\Console\Commands\Bookshelves;

use Artisan;
use App\Models\Book;
use App\Models\Serie;
use App\Models\Author;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:generate
                            {--f|fresh : reset current database to fresh install, execute seeders}
                            {--F|force : skip confirm question for prod}
                            {--c|covers : prevent generation of covers}
                            {--a|alone : prevent external HTTP requests to public API for additional informations}
                            {--l|limit= : limit epub files to generate, useful for debug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate books and covers database from storage/raw/books, set limit option at the end';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->newLine();
        $this->alert('Bookshelves: generate');

        $this->info('This tool will generate EPUB files and cover optimized files from EPUB files in storage/raw/books...');
        $this->info("Original EPUB files will not be deleted but they won't be used after current parsing.");
        $this->newLine();

        // setup options
        $isForce = $this->option('force');
        $isFresh = $this->option('fresh');
        $limit = $this->option('limit');
        $limit = str_replace('=', '', $limit);
        $limit = intval($limit);
        $no_covers = $this->option('covers');
        $alone = $this->option('alone');

        if ($isFresh) {
            $this->warn('- Option --fresh: erase current database, migrate and seed basics also clear all medias.');
        }
        if ($limit) {
            $this->warn("- Option --limit: limit eBooks generated to $limit.");
        }
        if ($no_covers) {
            $this->warn('- Option --covers: skip cover generation for Book, Serie and Author.');
        }
        if ($alone) {
            $this->warn('- Option --alone: skip HTTP requests.');
        }

        $isProd = 'production' === config('app.env') ? true : false;
        if ($isProd && ! $isForce) {
            if (! $this->confirm('You are in production environement, do you want really continue?')) {
                return;
            }
        }
        if ($isFresh) {
            $this->fresh();
        }

        /*
         * Generate commands
         */
        Artisan::call('bookshelves:books', [
            '--alone'  => $alone,
            '--covers' => $no_covers,
            '--limit'  => $limit,
        ], $this->getOutput());
        Artisan::call('bookshelves:series', [
            '--alone'  => $alone,
            '--covers' => $no_covers,
        ], $this->getOutput());
        Artisan::call('bookshelves:authors', [
            '--alone'  => $alone,
            '--covers' => $no_covers,
        ], $this->getOutput());

        /*
         * Tests
         */
        $this->alert('Tests');
        if ($this->confirm('Do you want to run tests?', true)) {
            $this->line('Run tests...');
            Artisan::call('bookshelves:test');
        }

        $this->newLine();
        $this->table(
            ['Books', 'Series', 'Authors'],
            [[Book::count(), Serie::count(), Author::count()]]
        );
        $this->newLine();

        Artisan::call('bookshelves:clear', [], $this->getOutput());

        $this->info('Done!');
    }

    /**
     * Clear all media collection manage by spatie/laravel-medialibrary.
     */
    public function clearAllMediaCollection(): bool
    {
        $isSuccess = false;

        try {
            $books = Book::all();
            $series = Serie::all();
            $authors = Author::all();
            $books->each(function ($query) {
                $query->clearMediaCollection('books');
                $query->clearMediaCollection('epubs');
            });
            $series->each(function ($query) {
                $query->clearMediaCollection('series');
            });
            $authors->each(function ($query) {
                $query->clearMediaCollection('authors');
            });
            $isSuccess = true;
        } catch (\Throwable $th) {
            //throw $th;
        }
        Storage::disk('public')->deleteDirectory('media');

        $this->newLine();
        $isSuccess ? $isSuccessText = 'success' : $isSuccessText = 'failed';
        $this->alert("Clearing media... $isSuccessText!");
        $this->info("Clear all files into 'public/storage/media' manage by spatie/laravel-medialibrary");

        return $isSuccess;
    }

    /**
     * Setup fresh mode.
     */
    public function fresh()
    {
        $this->clearAllMediaCollection();

        $this->newLine();
        $this->alert('Run migrate:fresh...');
        Artisan::call('migrate:fresh', ['--force' => true], $this->getOutput());
        $this->newLine();
        $this->comment('Run roles seeders');
        Artisan::call('db:seed', ['--class' => 'RoleSeeder', '--force' => true]);
        // Artisan::call('db:seed', ['--class' => 'UserSeeder', '--force' => true]);
        $this->info('Seeders ready!');
        $this->newLine();
    }
}
