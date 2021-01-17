<?php

namespace App\Console\Commands;

use DB;
use File;
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

        File::cleanDirectory(public_path('storage/cache'));
        Storage::disk('public')->copy('.gitignore-sample', 'cache/.gitignore');

        File::cleanDirectory(public_path('storage/covers'));
        Storage::disk('public')->copy('.gitignore-sample', 'covers/.gitignore');

        File::cleanDirectory(public_path('storage/books'));
        Storage::disk('public')->copy('.gitignore-sample', 'books/.gitignore');

        Artisan::call('migrate:fresh --seed --force');

        $files = Storage::disk('public')->allFiles('books-raw');
        foreach ($files as $key => $file) {
            if (array_key_exists('extension', pathinfo($file)) && 'epub' === pathinfo($file)['extension']) {
                $book = EpubParser::getMetadata($file);
                EpubParser::generateNewEpub($book, $file);
                $serie = null;
                if (null !== $book->serie) {
                    $serie = $book->serie;
                    $serie = $serie->title;
                }
                dump("$serie $book->serie_number $book->title");
            }
        }
        File::cleanDirectory(public_path('storage/covers-original'));
        Storage::disk('public')->copy('.gitignore-sample', 'covers-original/.gitignore');

        $this->info('Done!');
    }

    public function refreshDB(string $table)
    {
        $max = DB::table($table)->max('id') + 1;
        DB::statement("ALTER TABLE $table AUTO_INCREMENT =  $max");
    }
}
