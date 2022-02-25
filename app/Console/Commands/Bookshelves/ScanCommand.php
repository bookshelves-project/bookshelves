<?php

namespace App\Console\Commands\Bookshelves;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\FilesTypeParser;
use App\Models\Book;
use App\Services\DirectoryParserService;
use Illuminate\Console\Command;

class ScanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:scan';

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
        $app = config('app.name');
        $this->alert("{$app}: scan all EPUB files");
        $this->warn('Scan storage data books directory');

        $verbose = $this->option('verbose');

        $files = FilesTypeParser::parseDataFiles();

        $new_files = [];
        if (! $verbose) {
            $bar = $this->output->createProgressBar(sizeof($files));
            $bar->start();
        }
        foreach ($files as $key => $file) {
            $parser = ParserEngine::create($file);
            $book = Book::whereSlug($parser->title_slug_lang)->first();
            if (! $book) {
                array_push($new_files, $parser);
            }
            if (! $verbose) {
                $bar->advance();
            } else {
                $this->info($key.' '.pathinfo($file->path)['filename']);
            }
        }
        if (! $verbose) {
            $bar->finish();
            $this->newLine();
        }

        if (sizeof($new_files) > 0) {
            $this->newLine();
            $this->info('New files detected');
            $this->newLine();
            foreach ($new_files as $parser) {
                $this->info("- {$parser->title} from {$parser->file_name}");
            }
        }

        $this->newLine();
        $this->warn(sizeof(($files)).' files found');
        if (sizeof($new_files) > 0) {
            $this->warn(sizeof(($new_files)).' new files found, to add it to collection, you can use `bookshelves:generate`');
        }
        $this->newLine();

        $this->table(
            ['New books', 'Books'],
            [[sizeof($new_files), Book::count()]]
        );

        return $files;
    }
}
