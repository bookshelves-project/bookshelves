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

        File::cleanDirectory(public_path('storage/covers-basic'));
        Storage::disk('public')->copy('.gitignore-sample', 'covers-basic/.gitignore');

        File::cleanDirectory(public_path('storage/covers-original'));
        Storage::disk('public')->copy('.gitignore-sample', 'covers-original/.gitignore');

        File::cleanDirectory(public_path('storage/books'));
        Storage::disk('public')->copy('.gitignore-sample', 'books/.gitignore');

        Artisan::call('migrate:fresh --seed --force');

        $files = Storage::disk('public')->allFiles('books-raw');
        $epubsFiles = [];
        foreach ($files as $key => $value) {
            if (array_key_exists('extension', pathinfo($value)) && 'epub' === pathinfo($value)['extension']) {
                array_push($epubsFiles, $value);
            }
        }

        foreach ($epubsFiles as $key => $file) {
            $book = EpubParser::getMetadata($file);
            EpubParser::generateNewEpub($book, $file);
            $serie = null;
            if (null !== $book->serie) {
                $serie = $book->serie;
                $serie = $serie->title;
                $serie = $serie.' '.$book->serie_number.' ';
            }
            dump($key.' '.$serie.$book->title);
        }
        File::cleanDirectory(public_path('storage/covers-raw'));
        Storage::disk('public')->copy('.gitignore-sample', 'covers-raw/.gitignore');

        $this->info('Done!');
    }

    public function refreshDB(string $table)
    {
        $max = DB::table($table)->max('id') + 1;
        DB::statement("ALTER TABLE $table AUTO_INCREMENT =  $max");
    }
}
