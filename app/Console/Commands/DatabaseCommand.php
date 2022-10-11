<?php

namespace App\Console\Commands;

use App\Enums\MediaDiskEnum;
use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Review;
use App\Models\Serie;
use Artisan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Kiwilan\Steward\Console\CommandProd;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\Tag;

class DatabaseCommand extends CommandProd
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database
                            {--b|books : reset current books and relation, keep users}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup database';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $books = $this->option('books') ?? false;

        if ($books) {
            $this->fresh();
        } else {
            $this->info('Database migration...');
            if ($this->confirm('Do you want to migrate fresh database? /* THIS WILL ERASE ALL DATA */', false)) {
                Artisan::call('migrate:fresh --force', [], $this->getOutput());

                $this->newLine();
                $this->line('~ Database successfully migrated.');
            }
        }

        return Command::SUCCESS;
    }

    /**
     * Setup fresh mode.
     */
    public function fresh()
    {
        $this->comment('Bookshelves Database');
        $this->newLine();

        $this->clearBooksMediaCollection();

        $this->warn('Clear '.config('app.name').' data...');
        $this->newLine();
        $this->clearTables();
        $this->newLine();
    }

    /**
     * Clear all media collection manage by spatie/laravel-medialibrary.
     */
    public function clearBooksMediaCollection(): bool
    {
        $isSuccess = false;

        try {
            $books = Book::all();
            $series = Serie::all();
            $authors = Author::all();
            $books->each(function ($book) {
                /** @var Book $book */
                $book->clearMediaCollection(MediaDiskEnum::cover->value);
                $book->clearMediaCollection(MediaDiskEnum::format->value);
            });
            $series->each(function ($serie) {
                /** @var Serie $serie */
                $serie->clearMediaCollection(MediaDiskEnum::cover->value);
            });
            $authors->each(function ($author) {
                /** @var Author $author */
                $author->clearMediaCollection(MediaDiskEnum::cover->value);
            });
            $isSuccess = true;
        } catch (\Throwable $th) {
            // throw $th;
        }

        return $isSuccess;
    }

    public function clearAllMediaCollection(): bool
    {
        $isSuccess = false;

        Media::query()->delete();
        Storage::disk('public')->deleteDirectory('media');

        $this->newLine();
        $this->warn('Clearing media...');
        $this->info("Clear all files into 'public/storage/media' manage by spatie/laravel-medialibrary");

        return $isSuccess;
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
        $this->info('Truncate selectionables table');
        DB::table('selectionables')->truncate();

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
        $this->info('Truncate reviews table');
        Review::truncate();
        $this->info('Truncate tags table');
        Tag::truncate();

        DB::statement('SET foreign_key_checks=1');
    }
}
