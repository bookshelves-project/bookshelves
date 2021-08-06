<?php

namespace App\Console\Commands\Bookshelves;

use Illuminate\Console\Command;
use App\Providers\MetadataExtractor\MetadataExtractorTools;

class ScanCommand extends Command
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
     * @return false|array
     */
    public function handle(): false | array
    {
        $limit = $this->option('limit');
        $limit = str_replace('=', '', $limit);
        $limit = intval($limit);

        $verbose = $this->option('verbose');

        $this->alert('Bookshelves: scan all EPUB files');
        $this->warn('Scan public/storage/raw/books directory');

        $epubFiles = MetadataExtractorTools::getAllEpubFiles(limit: $limit);

        if ($verbose) {
            foreach ($epubFiles as $key => $file) {
                echo $key.' '.pathinfo($file)['filename']."\n";
            }
        }

        if ($limit) {
            return array_slice($epubFiles, 0, $limit);
        }

        $this->warn(sizeof(($epubFiles)).' EPUB files found');
        $this->newLine();

        return $epubFiles;
    }
}
