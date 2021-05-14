<?php

namespace App\Console\Commands\Bookshelves;

use Storage;
use Illuminate\Console\Command;

class ScanBooksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:scan
                            {--l|limit= : limit epub files to generate, useful for debug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan directory public/storage/raw/books to get all EPUB files.';

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
        $limit = $this->option('limit');
        $limit = str_replace('=', '', $limit);
        $limit = intval($limit);

        $verbose = $this->option('verbose');

        try {
            // Get all files in raw/books/
            $files = Storage::disk('public')->allFiles('raw/books');
        } catch (\Throwable $th) {
            dump('storage/raw/books not found');

            return false;
        }

        // Get EPUB files form raw/books/ and create new $epubsFiles[]
        $epubsFiles = [];
        foreach ($files as $key => $value) {
            if (array_key_exists('extension', pathinfo($value)) && 'epub' === pathinfo($value)['extension']) {
                array_push($epubsFiles, $value);
            }
        }

        if ($verbose) {
            foreach ($epubsFiles as $key => $file) {
                echo $key.' '.pathinfo($file)['filename']."\n";
            }
        }

        if ($limit) {
            return array_slice($epubsFiles, 0, $limit);
        }

        return $epubsFiles;

        return 0;
    }
}
