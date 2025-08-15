<?php

namespace App\Console\Commands\Bookshelves;

use App\Engines\Book\File\BookFileItem;
use App\Engines\Book\File\BookFileScanner;
use App\Facades\Bookshelves;
use App\Models\Library;
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
        $libraries = Library::inOrder();
        $engine = Bookshelves::analyzerEngine();

        $this->info("Engine: {$engine}.");
        $this->newLine();

        foreach ($libraries as $library) {
            $this->parseFiles($library, $verbose);
        }

        return Command::SUCCESS;
    }

    private function parseFiles(Library $library, bool $verbose)
    {
        $now = now();
        $starttime = microtime(true);
        $this->info("{$library->name} scanning at {$now->format('H:i:s')}...");
        $parser = BookFileScanner::make($library);

        $now = now();
        $endtime = microtime(true);
        if (! $parser) {
            $this->warn("{$library->name} no files found at {$now->format('H:i:s')} (took ".number_format($endtime - $starttime, 2).' seconds).');
            $this->newLine();

            return;
        }

        $this->info("{$library->name} {$parser->getCount()} files in {$library->path} at {$now->format('H:i:s')} (took ".number_format($endtime - $starttime, 2).' seconds).');

        if ($verbose) {
            $this->table(
                ['Basename', 'Extension', 'Library'],
                array_map(fn (BookFileItem $file) => [
                    $file->basename(),
                    $file->extension(),
                    $library->name,
                ], $parser->toBookFileItems())
            );
        }

        $this->newLine();
    }
}
