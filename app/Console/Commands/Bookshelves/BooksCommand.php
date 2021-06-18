<?php

namespace App\Console\Commands\Bookshelves;

use Str;
use Artisan;
use App\Models\Book;
use Spatie\Tags\Tag;
use Illuminate\Console\Command;
use App\Providers\Bookshelves\BookProvider;
use App\Providers\Bookshelves\BookshelvesProvider;
use App\Providers\MetadataExtractor\MetadataExtractor;
use App\Providers\MetadataExtractor\MetadataExtractorTools;

class BooksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:books
                            {--c|covers : prevent generation of covers}
                            {--a|alone : prevent external HTTP requests to public API for additional informations}
                            {--f|fresh : reset current books and relation, keep users}
                            {--l|limit= : limit epub files to generate, useful for debug}
                            {--d|debug= : generate metadata files into public/storage/debug for debug}';

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
        $limit = $this->option('limit');
        $limit = str_replace('=', '', $limit);
        $limit = intval($limit);
        $no_covers = $this->option('covers');
        $alone = $this->option('alone');
        $fresh = $this->option('fresh');
        $debug = $this->option('debug') ?? false;
        $epubFiles = MetadataExtractorTools::getAllEpubFiles(limit: $limit);

        if ($fresh) {
            $books = Book::all();
            $books->each(function ($query) {
                $query->clearMediaCollection('books');
                $query->clearMediaCollection('epubs');
            });
        }

        if (! $fresh) {
            $this->warn('No fresh, scan for new eBooks');
            $this->newLine();
            $epubFiles = $this->getOnlyNewBooks($epubFiles, $debug);
        }
        $this->newLine(2);

        /*
         * Books
         */
        $books = $this->books($epubFiles, $alone, $debug);

        /*
         * Books covers
         */
        if (! $no_covers) {
            $this->covers($books);
        }

        Artisan::call('bookshelves:clear', [], $this->getOutput());

        return true;
    }

    public function getOnlyNewBooks(array $epubFiles, bool $debug = false)
    {
        $epubFilesNew = [];
        $epub_bar = $this->output->createProgressBar(sizeof($epubFiles));
        $epub_bar->start();
        foreach ($epubFiles as $key => $epubFilePath) {
            $metadataExtractor = MetadataExtractor::run($epubFilePath);
            $slug = Str::slug($metadataExtractor->title.' '.$metadataExtractor->language);

            $book = Book::whereSlug($slug)->first();
            if (! $book) {
                array_push($epubFilesNew, $epubFilePath);
            }
            $epub_bar->advance();
        }
        $epub_bar->finish();

        return $epubFilesNew;
    }

    /**
     * Main method of Bookshelves.
     *
     * Generate `Book` model with all relationships
     */
    public function books(array $epubFiles, bool $alone, bool $debug = false): array
    {
        $this->alert('Bookshelves: books & relations');
        $this->comment('- EPUB files detected: '.sizeof($epubFiles));
        $this->info('- Generate Book model with relationships');
        $this->info('- Generate new EPUB file with standard name');
        if (! $alone) {
            $this->info('- Get extra data from Google Books API: HTTP requests');
        }
        $this->newLine();

        $genres = config('bookshelves.genres');
        foreach ($genres as $key => $genre) {
            Tag::findOrCreate($genre, 'genre');
        }

        $epub_bar = $this->output->createProgressBar(sizeof($epubFiles));
        $epub_bar->start();
        $books = [];
        foreach ($epubFiles as $key => $epubFilePath) {
            $metadataExtractor = MetadataExtractor::run($epubFilePath, $debug);
            // Check if XML have no error
            if ($metadataExtractor) {
                $tryToFindBook = Book::whereSlug(Str::slug($metadataExtractor->title))->first();
                if (! $tryToFindBook) {
                    $new_book = BookshelvesProvider::convertMetadata(metadataExtractor: $metadataExtractor, alone: $alone);
                    BookProvider::epub(book: $new_book, epubFilePath: $epubFilePath);
                    array_push($books, $new_book);
                }
            }
            $epub_bar->advance();
        }
        $epub_bar->finish();
        $this->newLine(2);

        return $books;
    }

    /**
     * Generate covers with different dimensions.
     *
     * Format can be specify into `bookshelves` config
     */
    public function covers(array $books)
    {
        $format = config('bookshelves.cover_extension');
        $this->comment('Generate covers...');
        $this->newLine();
        $this->info('- Generate covers with differents dimensions');
        $this->info("- $format format: original from EPUB, thumbnail");
        $this->info('- Open Graph in JPG format');
        $this->newLine();

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
