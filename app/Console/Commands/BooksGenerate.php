<?php

namespace App\Console\Commands;

use Artisan;
use Storage;
use App\Utils\EpubParser;
use Illuminate\Console\Command;

class BooksGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate books database from storage/books';

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
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Generate books from storage/books-raw...');

        Artisan::call('storage:link');

        Storage::disk('public')->deleteDirectory('covers');
        Storage::disk('public')->makeDirectory('covers');
        Storage::disk('public')->copy('.gitignore-sample', 'covers/.gitignore');

        Storage::disk('public')->deleteDirectory('books');
        Storage::disk('public')->makeDirectory('books');
        Storage::disk('public')->copy('.gitignore-sample', 'books/.gitignore');

        $files = Storage::disk('public')->allFiles('books-raw');
        foreach ($files as $key => $file) {
            if (array_key_exists('extension', pathinfo($file)) && 'epub' === pathinfo($file)['extension']) {
                $book = EpubParser::getMetadata($file);
                EpubParser::generateNewEpub($book, $file);
                dump(pathinfo($file)['filename']);
            }
        }

        $this->info('Done!');
    }
}
