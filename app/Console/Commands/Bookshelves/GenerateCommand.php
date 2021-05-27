<?php

namespace App\Console\Commands\Bookshelves;

use Artisan;
use App\Models\Book;
use App\Models\Serie;
use App\Models\Author;
use App\Models\Comment;
use App\Models\Favoritable;
use App\Models\GoogleBook;
use App\Models\Identifier;
use App\Models\Language;
use App\Models\Publisher;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Spatie\Tags\Tag;

class GenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:generate
                            {--f|fresh : reset current books and relation, keep users}
                            {--F|force : skip confirm question for prod}
                            {--c|covers : prevent generation of covers}
                            {--a|alone : prevent external HTTP requests to public API for additional informations}
                            {--l|limit= : limit epub files to generate, useful for debug}
                            {--d|debug= : generate metadata files into public/storage/debug for debug}';

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
        $debug = $this->option('debug');

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
            '--fresh' => $isFresh,
            '--limit'  => $limit,
            '--debug'  => $debug,
        ], $this->getOutput());
        Artisan::call('bookshelves:series', [
            '--alone'  => $alone,
            '--fresh' => $isFresh,
            '--covers' => $no_covers,
        ], $this->getOutput());
        Artisan::call('bookshelves:authors', [
            '--alone'  => $alone,
            '--fresh' => $isFresh,
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
        $this->alert('Clear Bookshelves data...');
        // Artisan::call('migrate:fresh', ['--force' => true], $this->getOutput());
        $this->clearTables();
        $this->newLine();
    }
    
    public function clearTables()
    {
        DB::statement('SET foreign_key_checks=0');
        
        $this->info('Truncate authorables table');
        DB::table('authorables')->truncate();
        $this->info('Truncate favoritables table');
        DB::table('favoritables')->truncate();
        $this->info('Truncate taggables table');
        DB::table('taggables')->truncate();

        $this->info('Truncate books table');
        Book::truncate();
        $this->info('Truncate series table');
        Serie::truncate();
        $this->info('Truncate authors table');
        Author::truncate();
        $this->info('Truncate publishers table');
        Publisher::truncate();
        $this->info('Truncate languages table');
        Language::truncate();
        $this->info('Truncate identifiers table');
        Identifier::truncate();
        $this->info('Truncate comments table');
        Comment::truncate();
        $this->info('Truncate google_books table');
        GoogleBook::truncate();
        $this->info('Truncate tags table');
        Tag::truncate();
        
        DB::statement('SET foreign_key_checks=1');
    }
}
