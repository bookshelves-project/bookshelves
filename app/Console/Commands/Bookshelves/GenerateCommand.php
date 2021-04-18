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
    protected $signature = 'bs:generate
                            {--f|fresh : reset current database to fresh install, execute seeders}
                            {--d|debug : default author pictures, no covers, skip tests}
                            {--F|force : skip confirm question for fresh prod}
                            {--l|limit= : limit epub files to generate, useful for debug}
                            {--s|skip : skip tests}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate books and covers database from storage/books-raw';

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

        $this->info('This tool will generate EPUB files and cover optimized files from EPUB files in storage/books-raw...');
        $this->info("Original EPUB files will not be deleted but they won't be used after current parsing.");
        $this->newLine();

        // setup options
        $isDebug = $this->option('debug');
        if ($isDebug) {
            $this->warn('You are in debug mode: default author pictures, basic cover only');
        }
        $isForce = $this->option('force');
        $isFresh = $this->option('fresh');
        if ($isFresh) {
            $this->warn('You choose fresh installation, current database will be erased. Seeders will be used.');

            $this->clearAllMediaCollection();

            $this->newLine();
            $this->alert('Run migrate:fresh...');
            $command = 'migrate:fresh --force';
            Artisan::call($command, [], $this->getOutput());
            $this->newLine();
            $this->comment('Run roles and users seeders');
            Artisan::call('db:seed --class RoleSeeder', []);
            Artisan::call('db:seed --class UserSeeder', []);
            $this->info('Seeders ready!');
            $this->newLine();
        }
        $skip = $this->option('skip');
        $limit = $this->option('limit');
        $limit = str_replace('=', '', $limit);
        $limit = intval($limit);

        Artisan::call("bs:books -l=$limit", [], $this->getOutput());
        Artisan::call('bs:covers', [], $this->getOutput());
        Artisan::call('bs:series', [], $this->getOutput());
        Artisan::call('bs:authors', [], $this->getOutput());

        if ('production' !== config('app.env') && ! $isDebug && ! $skip) {
            $this->alert('Run tests...');
            Artisan::call('pest:run');
        }

        $this->newLine();
        $this->table(
            ['Books', 'Series', 'Authors'],
            [[Book::count(), Serie::count(), Author::count()]]
        );
        $this->newLine();

        $this->info('Done!');
    }

    /**
     * Clear all media collection manage by spatie/laravel-medialibrary.
     *
     * @return bool
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
}
