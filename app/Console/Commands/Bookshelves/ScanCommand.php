<?php

namespace App\Console\Commands\Bookshelves;

use App\Engines\ConverterEngine;
use App\Engines\ParserEngine;
use App\Engines\ParserEngine\Parsers\FilesTypeParser;
use App\Models\Book;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\CommandSteward;

class ScanCommand extends CommandSteward
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
     *
     * @return int
     */
    public function handle()
    {
        $this->title(description: 'Scan storage data books directory');

        $verbose = $this->option('verbose');

        $files = FilesTypeParser::parseDataFiles();

        $new_files = [];
        if (! $verbose) {
            $bar = $this->output->createProgressBar(count($files));
            $bar->start();
        }
        foreach ($files as $key => $file) {
            $parser_engine = ParserEngine::make($file);
            $converter_engine = new ConverterEngine($parser_engine);
            $is_exist = $converter_engine->retrieveBook();
            if (! $is_exist) {
                array_push($new_files, $parser_engine);
            }
            if (! $verbose) {
                $bar->advance();
            } else {
                $this->info($key.' '.pathinfo($file->path, PATHINFO_FILENAME));
            }
        }
        if (! $verbose) {
            $bar->finish();
            $this->newLine();
        }

        if (count($new_files) > 0) {
            $this->newLine();
            $this->info('New files detected');
            $this->newLine();
            foreach ($new_files as $parser_engine) {
                if ($parser_engine instanceof ParserEngine) {
                    $this->info("- {$parser_engine->title} from {$parser_engine->file_name}");
                }
            }
        }

        $this->newLine();
        $this->warn(count($files).' files found');
        if (count($new_files) > 0) {
            $this->warn(count($new_files).' new files found, to add it to collection, you can use `bookshelves:generate`');
        }
        if (0 === count($new_files) && count($files) !== Book::count()) {
            $this->warn('Some duplicates detected!');
        }
        $this->newLine();

        $this->table(
            ['New books', 'Books'],
            [[count($new_files), Book::count()]]
        );

        return Command::SUCCESS;
    }
}
