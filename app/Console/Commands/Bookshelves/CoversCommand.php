<?php

namespace App\Console\Commands\Bookshelves;

use App\Models\Book;
use Illuminate\Console\Command;
use App\Providers\Bookshelves\CoverGenerator;

class CoversCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bs:covers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $format = config('bookshelves.cover_extension');
        $this->alert('Bookshelves: covers (for books)');
        $this->info('- Generate covers with differents dimensions');
        $this->info("- $format format: original from EPUB, thumbnail");
        $this->info('- Open Graph in JPG format');
        $this->newLine();

        $books = Book::all();
        $bar = $this->output->createProgressBar(count($books));
        $bar->start();
        foreach ($books as $key => $book) {
            CoverGenerator::run(book: $book);
            $bar->advance();
        }
        $bar->finish();
        $this->newLine(2);

        $dir = 'public/storage/covers-raw';
        $leave_files = ['.gitignore'];

        foreach (glob("$dir/*") as $file) {
            if (! in_array(basename($file), $leave_files)) {
                unlink($file);
            }
        }

        return 0;
    }
}
