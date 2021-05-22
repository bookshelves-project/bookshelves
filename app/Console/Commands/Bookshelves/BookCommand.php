<?php

namespace App\Console\Commands\Bookshelves;

use Str;
use Cache;
use App\Models\Book;
use Illuminate\Console\Command;
use App\Providers\Bookshelves\BookProvider;
use App\Providers\Bookshelves\BookshelvesProvider;
use App\Providers\MetadataExtractor\MetadataExtractor;
use App\Providers\MetadataExtractor\MetadataExtractorTools;

class BookCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:books
                            {--c|covers : prevent generation of covers}
                            {--l|limit= : limit epub files to generate, useful for debug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bookshelves command to generate Book model with all relationships and generate covers with different dimensions, set limit option at the end';

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
     * @return bool
     */
    public function handle()
    {
        Cache::forget('books');

        $limit = $this->option('limit');
        $limit = str_replace('=', '', $limit);
        $limit = intval($limit);
        $no_covers = $this->option('covers');
        $epubFiles = MetadataExtractorTools::getAllEpubFiles(limit: $limit);

        /*
         * Books
         */
        $this->books($epubFiles);

        /*
         * Books covers
         */
        if (! $no_covers) {
            $this->covers();
        }

        return true;
    }

    /**
     * Main method of Bookshelves.
     *
     * Generate `Book` model with all relationships
     *
     * @param array $epubFiles
     *
     * @return void
     */
    public function books(array $epubFiles)
    {
        $this->alert('Bookshelves: books & relations');
        $this->comment('- EPUB files detected: ' . sizeof($epubFiles));
        $this->info('- Generate Book model with relationships');
        $this->info('- Generate new EPUB file with standard name');
        $this->info('- Get extra data from Google Books API: HTTP requests');
        $this->newLine();

        $epub_bar = $this->output->createProgressBar(sizeof($epubFiles));
        $epub_bar->start();
        foreach ($epubFiles as $key => $epubFilePath) {
            $metadataExtractor = MetadataExtractor::run($epubFilePath);
            // Check if XML have no error
            if ($metadataExtractor) {
                $tryToFindBook = Book::whereSlug(Str::slug($metadataExtractor->title))->first();
                if (! $tryToFindBook) {
                    $new_book = BookshelvesProvider::convertMetadata(metadataExtractor: $metadataExtractor);
                    BookProvider::epub(book: $new_book, epubFilePath: $epubFilePath);
                }
            }
            $epub_bar->advance();
        }
        $epub_bar->finish();
        $this->newLine(2);
    }

    /**
     * Generate covers with different dimensions.
     *
     * Format can be specify into `bookshelves` config
     */
    public function covers()
    {
        $format = config('bookshelves.cover_extension');
        $this->comment('Generate covers...');
        $this->newLine();
        $this->info('- Generate covers with differents dimensions');
        $this->info("- $format format: original from EPUB, thumbnail");
        $this->info('- Open Graph in JPG format');
        $this->newLine();

        $books = Book::all();
        $bar = $this->output->createProgressBar(count($books));
        $bar->start();
        foreach ($books as $key => $book) {
            BookProvider::cover(book: $book);
            $bar->advance();
        }
        $bar->finish();
        $this->newLine(2);

        $dir = 'public/storage/raw/covers';
        $leave_files = ['.gitignore'];

        foreach (glob("$dir/*") as $file) {
            if (! in_array(basename($file), $leave_files)) {
                unlink($file);
            }
        }

        return 0;
    }
}
