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
    protected $signature = 'bookshelves:scan
                            {--p|parse : Parse with engine}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan directory public/storage/data/books to get all BookFormatEnum files.';

    /**
     * Create a new command instance.
     */
    public function __construct(
        public bool $verbose = false,
        public bool $parse = false,
    ) {
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

        $this->verbose = $this->option('verbose') ?? false;
        $this->parse = $this->option('parse') ?? false;

        $files = FilesTypeParser::make();

        $list = [];
        if ($this->parse) {
            $list = $this->parser($files);
        } else {
            $list = $this->basic($files);
        }

        $this->table(
            ['New books', 'Books'],
            [[count($list), Book::count()]]
        );

        return Command::SUCCESS;
    }

    /**
     * @param FilesTypeParser[] $files
     *
     * @return FilesTypeParser[]
     */
    private function basic(array $files)
    {
        $books = Book::all()->map(fn (Book $book) => $book->physical_path)->toArray();

        /** @var FilesTypeParser[] */
        $list = [];
        foreach ($files as $key => $file) {
            if (! in_array($file->path, $books)) {
                $list["{$key}"] = $file;
                if ($this->verbose) {
                    $this->info("New book: {$file->path}");
                }
            }
        }

        return $list;
    }

    /**
     * @param FilesTypeParser[] $files
     *
     * @return ParserEngine[]
     */
    private function parser(array $files)
    {
        /** @var ParserEngine[] */
        $new_files = [];
        $bar = $this->output->createProgressBar(count($files));

        if (! $this->verbose) {
            $bar->start();
        }
        foreach ($files as $key => $file) {
            $parser_engine = ParserEngine::make($file);
            $converter_engine = new ConverterEngine($parser_engine);
            $is_exist = $converter_engine->retrieveBook();
            if (! $is_exist) {
                $new_files[] = $parser_engine;
            }
            if (! $this->verbose) {
                $bar->advance();
            } else {
                $this->info($key.' '.pathinfo($file->path, PATHINFO_FILENAME));
            }
        }
        if (! $this->verbose) {
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

        return $new_files;
    }
}
