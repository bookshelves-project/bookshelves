<?php

namespace App\Console\Commands\Bookshelves;

use App\Engines\Book\BookFileReader;
use App\Engines\Book\BookFilesReader;
use App\Engines\BookEngine;
use App\Models\Book;
use Illuminate\Console\Command;
use Kiwilan\Ebook\Ebook;
use Kiwilan\Steward\Commands\Commandable;

class ScanCommand extends Commandable
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

        $this->verbose = $this->option('verbose') ?: false;
        $this->parse = $this->option('parse') ?: false;

        $files = BookFilesReader::make();

        $list = [];

        if ($this->parse) {
            $list = $this->parser($files->items());
        } else {
            $list = $this->basic($files->items());
        }

        $this->table(
            ['New books', 'Books'],
            [[count($list), Book::count()]]
        );

        return Command::SUCCESS;
    }

    /**
     * @param  BookFileReader[]  $files
     * @return BookFileReader[]
     */
    private function basic(array $files)
    {
        $books = Book::all()->map(fn (Book $book) => $book->physical_path)->toArray();

        /** @var BookFilesReader[] */
        $list = [];

        foreach ($files as $key => $file) {
            if (! in_array($file->path(), $books)) {
                $list["{$key}"] = $file;

                if ($this->verbose) {
                    $this->info("New book: {$file->path()}");
                }
            }
        }

        return $list;
    }

    /**
     * @param  BookFileReader[]  $files
     * @return Ebook[]
     */
    private function parser(array $files)
    {
        /** @var Ebook[] */
        $newFiles = [];
        $bar = $this->output->createProgressBar(count($files));

        if (! $this->verbose) {
            $bar->start();
        }

        foreach ($files as $key => $file) {
            $engine = BookEngine::make($file, $this->verbose);
            $isExist = $engine->converter()->retrieveBook();

            if (! $isExist) {
                $newFiles[] = $engine->converter()->book();
            }

            if (! $this->verbose) {
                $bar->advance();
            } else {
                $this->info($key.' '.pathinfo($file->path(), PATHINFO_FILENAME));
            }
        }

        if (! $this->verbose) {
            $bar->finish();
            $this->newLine();
        }

        if (count($newFiles) > 0) {
            $this->newLine();
            $this->info('New files detected');
            $this->newLine();

            foreach ($newFiles as $parser) {
                if ($parser instanceof Ebook) {
                    $this->info("- {$parser->getTitle()}");
                }
            }
        }

        $this->newLine();
        $this->warn(count($files).' files found');

        if (count($newFiles) > 0) {
            $this->warn(count($newFiles).' new files found, to add it to collection, you can use `bookshelves:generate`');
        }

        if (count($newFiles) === 0 && count($files) !== Book::count()) {
            $this->warn('Some duplicates detected!');
        }
        $this->newLine();

        return $newFiles;
    }
}
