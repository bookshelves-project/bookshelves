<?php

namespace App\Console\Commands;

use Str;
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
        $this->info('Generate books from storage/books...');

        Artisan::call('storage:link');

        File::cleanDirectory(storage_path('app/public/covers'));
        $files = Storage::disk('public')->allFiles('books');
        // foreach ($files as $key => $file) {
        //     if (array_key_exists('extension', pathinfo($file)) && 'epub' === pathinfo($file)['extension']) {
        //         $filename_origin = pathinfo($file)['filename'];
        //         $file_name = Str::slug($filename_origin, '-').'.'.pathinfo($file)['extension'];
        //         dump($file_name);
        //         Storage::disk('public')->rename($file, "books/$file_name");
        //     }
        // }
        foreach ($files as $key => $file) {
            if (array_key_exists('extension', pathinfo($file)) && 'epub' === pathinfo($file)['extension']) {
                $book = EpubParser::getMetadata($file);
                EpubParser::renameEbook($book, $file);
                dump(pathinfo($file)['filename']);
            }
        }

        $this->info('Done!');
    }
}
