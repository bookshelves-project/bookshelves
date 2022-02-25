<?php

namespace App\Console\Commands\Bookshelves;

use App\Engines\ParserEngine;
use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Serie;
use App\Models\TagExtend;
use App\Services\DirectoryParserService;
use Illuminate\Console\Command;

class ScanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:scan
                            {--l|limit= : limit files to generate, useful for debug}
                            {--n|new : display new eBooks}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan directory public/storage/data/books to get all EPUB files.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): false|array
    {
        $limit = intval(str_replace('=', '', $this->option('limit')));
        $new = $this->option('new');

        $verbose = $this->option('verbose');

        $app = config('app.name');
        $this->alert("{$app}: scan all EPUB files");
        $this->warn('Scan public/storage/data/books directory');

        $files = DirectoryParserService::getFilesList(limit: $limit);

        if ($verbose) {
            foreach ($files as $key => $file) {
                echo $key.' '.pathinfo($file)['filename']."\n";
                if ($new) {
                    $parser = ParserEngine::create($file);
                }
            }
        }

        if ($limit) {
            return array_slice($files, 0, $limit);
        }

        $this->warn(sizeof(($files)).' EPUB files found');
        $this->newLine();

        $this->table(
            ['Books', 'Series', 'Authors', 'Languages', 'Publishers', 'Tags'],
            [[Book::count(), Serie::count(), Author::count(), Language::count(), Publisher::count(), TagExtend::count()]]
        );

        return $files;
    }
}
