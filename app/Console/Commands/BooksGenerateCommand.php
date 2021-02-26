<?php

namespace App\Console\Commands;

use App\Models\Author;
use File;
use Artisan;
use Storage;
use App\Models\Book;
use App\Models\Serie;
use App\Providers\Bookshelves\ConvertEpubParser;
use App\Providers\Bookshelves\EpubGenerator;
use App\Providers\Bookshelves\CoverGenerator;
use App\Providers\Bookshelves\ExtraDataGenerator;
use App\Providers\EpubParser\EpubParser;
use App\Providers\EpubParser\EpubParserTools;
use Cache;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class BooksGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:generate
                            {--f|fresh : reset current database to fresh install}
                            {--d|debug : default author pictures, no covers, skip tests}
                            {--F|force : skip confirm question for fresh prod}
                            {--l|limit= : limit epub files to generate, useful for debug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate books and covers database from storage/books-raw';

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
    public function handle(): bool
    {
        // Artisan::call('log:clear');
        
        // setup options
        $isDebug = $this->option('debug');
        $isForce = $this->option('force');
        $isFresh = $this->option('fresh');
        $limit = $this->option('limit');
        $limit = str_replace('=', '', $limit);
        $limit = intval($limit);

        if ($isDebug) {
            $this->warn('You are in debug mode: default author pictures, basic cover only');
        }
        if ($isFresh) {
            $this->warn('You choose fresh installation, current database will be erased.');
        }

        $this->info("\n".'> Welcome to Books-Generate Tool <'."\n");
        $this->info('This tool will generate EPUB files and cover optimized files from EPUB files in storage/books-raw...');
        $this->info("Original EPUB files will not be deleted but they won't be used after current parsing.");

        Artisan::call('storage:link');
        Cache::forget('books');
        Cache::forget('series');
        Cache::forget('authors');
        $epubFiles = EpubParserTools::getAllEpubFiles(limit: $limit);

        if ($isFresh) {
            $isProd = 'production' === config('app.env');
            if ($isProd && ! $isForce) {
                if ($this->confirm('App is in production, do you want really erase database?', false)) {
                    $this->generate(epubFiles: $epubFiles, isFresh: $isFresh, isDebug: $isDebug);
                } else {
                    $this->info('Operation cancel by user.');
                    $this->info('Use not --fresh, -f option to add only unknown EPUB files.');
                }
            } else {
                $this->generate(epubFiles: $epubFiles, isFresh: $isFresh, isDebug: $isDebug);
            }
        } else {
            $this->info("\n");
            $this->info('You choose basic parsing, current database will be keep safe and unknown eBooks will be add.');
            $this->warn("Basic parsing is not fully tested, to generate database with full try --fresh option for ready command");

            $this->generate(epubFiles: $epubFiles, isFresh: $isFresh, isDebug: $isDebug);
        }

        return true;
    }
    
    /**
     * 
     * @param array $epubFiles 
     * @param bool $isFresh 
     * @param bool $isDebug 
     * @return void 
     */
    public function generate(array $epubFiles, bool $isFresh, bool $isDebug = false) {
        if ($isFresh) {
            Artisan::call('migrate:fresh --force');
            $this->clearDirectories();
        }

        $books_with_covers = $this->generateBooks(epubFiles: $epubFiles, isDebug: $isDebug);
        $this->generateCovers(books_with_covers: $books_with_covers, isDebug: $isDebug);
        
        if (config('app.env') !== 'production' && !$isDebug) {
            $this->info('Run tests'."\n");
            Artisan::call('pest:run');
        }
        
        if ($isFresh) {
            $this->info('Run seeders...'."\n");
            Artisan::call('db:seed --force');
        }
        
        $process = new Process(['git checkout .']);
        $process->setTimeout(0);
        $process->start();
        $iterator = $process->getIterator($process::ITER_SKIP_ERR | $process::ITER_KEEP_OUTPUT);
        foreach ($iterator as $data) {
            echo $data;
        }
        
        $this->info('Done!');
    }

    public function generateCovers(array $books_with_covers, bool $isDebug = false)
    {
        if (!$isDebug) {
            $format = strtoupper(config('bookshelves.cover_extension'));
            $this->info("\n".'Generate covers');
            $this->info("- Generate covers with differents dimensions");
            $this->info("- $format format: original, basic, thumbnail\n");
            $cover_bar = $this->output->createProgressBar(count($books_with_covers));
            $cover_bar->start();
            foreach ($books_with_covers as $key => $metadata) {
                if ($metadata['cover'] !== null) {
                    CoverGenerator::run(metadata: $metadata);
                    $cover_bar->advance();
                }
            }

            $cover_bar->finish();
            $this->info("\n");
            $this->info('Covers generated!'."\n");
        }

        $this->info('Generate series covers and extra data');
        $this->info("- Get cover of vol. 1 to associate picture to serie");
        $this->info("- If a JPG file with slug of serie exist in 'database/seeders/media/series', it's will be this picture\n");
        $series = Serie::all();
        $series_cover_bar = $this->output->createProgressBar(count($series));
        $series_cover_bar->start();
        foreach ($series as $key => $serie) {
            ExtraDataGenerator::generateSerieCover(serie: $serie);
            ExtraDataGenerator::generateSerieLanguage(serie: $serie);
            $series_cover_bar->advance();
        }
        $series_cover_bar->finish();
        $this->info("\n");
        $this->info('Series Covers generated!'."\n");

        if (!$isDebug) {
            $this->info('Generate authors pictures');
            $this->info("- Get pictures from Wikipedia: HTTP requests\n");
            $authors = Author::all();
            $authors_pictures = $this->output->createProgressBar(count($authors));
            $authors_pictures->start();
            foreach ($authors as $key => $author) {
                ExtraDataGenerator::generateAuthorPicture(author: $author, is_debug: $isDebug);
                $authors_pictures->advance();
            }
            $authors_pictures->finish();
            $this->info("\n");
            $this->info('Authors Pictures generated!'."\n");
        }

        File::cleanDirectory(public_path('storage/covers-raw'));
        Storage::disk('public')->copy('.gitignore-sample', 'covers-raw/.gitignore');
    }

    public function generateBooks(array $epubFiles, bool $isDebug = false)
    {
        // Parse $epubsFiles[] to get metadata and
        // save each EPUB as Book model with relationships
        $epubsCount = sizeof($epubFiles);
        $this->info("\nEPUB files detected: $epubsCount");
        $this->info("- Generate Book model with relationships");
        $this->info("- Generate new EPUB file with standard name");
        $this->info("- Get extra data from Google Books API: HTTP requests\n");
        $books_with_covers = [];
        $books_with_errors = [];

        // Extract metadata for each EPUB
        // Generate new EPUB file with standard name
        $epub_bar = $this->output->createProgressBar($epubsCount);
        $epub_bar->start();
        foreach ($epubFiles as $key => $filePath) {
            $epubParser = EpubParser::run($filePath, $isDebug);
            $tryToFindBook = Book::whereSlug(Str::slug($epubParser->title))->first();
            if (!$tryToFindBook) {
                $book_created = ConvertEpubParser::run(epubParser: $epubParser, is_debug: $isDebug);
                EpubGenerator::run(book: $book_created, file_path: $filePath);

                array_push($books_with_covers, [
                    'book' => $book_created,
                    'cover' => $epubParser->cover,
                    'cover_extension' =>$epubParser->cover_extension
                ]);
            }
            $epub_bar->advance();
        }
        $epub_bar->finish();
        $this->info("\n");
        $this->info('EPUB files parsed and generated!');
        if (!empty($books_with_errors)) {
            $this->info("\n");
            $this->warn('You have '.sizeof($books_with_errors).' fatal errors: XML file failed to be parsed');
            foreach ($books_with_errors as $key => $book) {
                $this->info($book);
            }
        }

        return $books_with_covers;
    }

    

    /**
     * Clean directories with generated covers and EPUB files
     * Don't erase original EPUB files.
     *
     * @return bool
     */
    public function clearDirectories()
    {
        try {
            // Dir where download author image
            $author_path = 'media/authors';
            $author = File::cleanDirectory(public_path("storage/$author_path"));
            Storage::disk('public')->copy('.gitignore-sample', "$author_path/.gitignore");

            // Dir for thumbnails 240 x 320 and optimize
            // File::cleanDirectory(public_path('storage/covers/thumbnail'));
            // Storage::disk('public')->copy('.gitignore-sample', 'covers/thumbnail/.gitignore');

            // Dir for covers resized 480 x 640 and optimize
            $book_path = 'media/books';
            File::cleanDirectory(public_path("storage/$book_path"));
            Storage::disk('public')->copy('.gitignore-sample', "$book_path/.gitignore");
            
            $book_epub_path = 'media/books_epubs';
            File::cleanDirectory(public_path("storage/media/books_epubs"));
            Storage::disk('public')->copy('.gitignore-sample', "$book_epub_path/.gitignore");

            // Dir for original covers not resized but optimize
            // File::cleanDirectory(public_path('storage/covers/original'));
            // Storage::disk('public')->copy('.gitignore-sample', 'covers/original/.gitignore');

            $serie_path = 'media/series';
            File::cleanDirectory(public_path("storage/$serie_path"));
            Storage::disk('public')->copy('.gitignore-sample', "$serie_path/.gitignore");
        } catch (\Throwable $th) {
            dump('Error on clearDirectories()');
        }

        return true;
    }

    public function printEbook(Book $book, int $key)
    {
        $serie = null;
        if (null !== $book->serie) {
            $serie = $book->serie;
            $serie = $serie->title;
            $serie = $serie.' '.$book->serie_number.' - ';
        }
        $this->info($key.' '.$serie.$book->title);
    }
}
