<?php

namespace App\Console\Commands\Bookshelves;

use App\Engines\Book\BookFileItem;
use App\Engines\Book\BookFileScanner;
use App\Enums\BookTypeEnum;
use App\Facades\Bookshelves;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

class ScanCommand extends Commandable
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
    protected $description = 'Scan books to get all files.';

    /**
     * Create a new command instance.
     */
    public function __construct(
        public bool $verbose = false,
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
        $this->title();

        $verbose = $this->option('verbose');
        $enums = BookTypeEnum::cases();
        $engine = Bookshelves::analyzerEngine();

        $this->info("Engine: {$engine}.");
        $this->newLine();

        foreach ($enums as $enum) {
            $this->parseFiles($enum, $verbose);
        }

        return Command::SUCCESS;
    }

    private function parseFiles(BookTypeEnum $enum, bool $verbose)
    {
        $this->info("{$enum->value} scanning...");
        $parser = BookFileScanner::make($enum);

        if (! $parser) {
            $this->warn("{$enum->value} no files.");
            $this->newLine();

            return;
        }

        $library = $enum->libraryPath();
        $this->info("{$enum->value} {$parser->count()} files in {$library}.");

        if ($verbose) {
            $this->table(
                ['Basename', 'Format', 'Type'],
                array_map(fn (BookFileItem $file) => [
                    $file->basename(),
                    $file->format()->value,
                    $file->type()->libraryPath(),
                ], $parser->items())
            );
        }

        $this->newLine();
    }
}
