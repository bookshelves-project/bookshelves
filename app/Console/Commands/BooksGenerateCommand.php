<?php

namespace App\Console\Commands;

use File;
use Cache;
use Artisan;
use Storage;
use App\Models\Tag;
use App\Models\Book;
use App\Models\Serie;
use App\Models\Author;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Providers\EpubParser\EpubParser;
use App\Providers\Bookshelves\EpubGenerator;
use App\Providers\Bookshelves\CoverGenerator;
use App\Providers\Bookshelves\ExtraDataGenerator;
use App\Providers\MetadataExtractor\MetadataExtractor;
use App\Providers\Bookshelves\ConvertMetadataExtractor;
use App\Providers\MetadataExtractor\MetadataExtractorTools;

class BooksGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:generate
                            {--f|fresh : reset current database to fresh install, execute seeders}
                            {--d|debug : default author pictures, no covers, skip tests}
                            {--F|force : skip confirm question for fresh prod}
                            {--l|limit= : limit epub files to generate, useful for debug}
                            {--s|skip : skip tests}';

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
     * @return int
     */
    public function handle(): int
    {
        // Artisan::call('log:clear');

        // setup options
        $isDebug = $this->option('debug');
        $isForce = $this->option('force');
        $isFresh = $this->option('fresh');
        $skip = $this->option('skip');
        $limit = $this->option('limit');
        $limit = str_replace('=', '', $limit);
        $limit = intval($limit);

        if ($isDebug) {
            $this->warn('You are in debug mode: default author pictures, basic cover only');
        }
        if ($isFresh) {
            $this->warn('You choose fresh installation, current database will be erased. Seeders will be used.');
        }

        $this->newLine();
        $this->alert('BooksGenerate');
        $this->info('This tool will generate EPUB files and cover optimized files from EPUB files in storage/books-raw...');
        $this->info("Original EPUB files will not be deleted but they won't be used after current parsing.");

        Artisan::call('storage:link');
        Cache::forget('books');
        Cache::forget('series');
        Cache::forget('authors');
        $epubFiles = MetadataExtractorTools::getAllEpubFiles(limit: $limit);

        $booksGenerated = null;
        if ($isFresh) {
            $isProd = 'production' === config('app.env');
            if ($isProd && ! $isForce) {
                if ($this->confirm('App is in production, do you want really erase database?', false)) {
                    $booksGenerated = $this->generate(epubFiles: $epubFiles, isFresh: $isFresh, isDebug: $isDebug, skip: $skip);
                } else {
                    $this->info('Operation cancel by user.');
                    $this->info('Use not --fresh, -f option to add only unknown EPUB files.');
                }
            } else {
                $booksGenerated = $this->generate(epubFiles: $epubFiles, isFresh: $isFresh, isDebug: $isDebug, skip: $skip);
            }
        } else {
            $this->newLine();
            $this->info('You choose basic parsing, current database will be keep safe and unknown eBooks will be add.');
            $this->warn('Basic parsing is not fully tested, to generate database with full try --fresh option for ready command');

            $booksGenerated = $this->generate(epubFiles: $epubFiles, isFresh: $isFresh, isDebug: $isDebug, skip: $skip);
        }

        return $booksGenerated;
    }

    /**
     * Execute generateBooks() and generateCovers()
     * - If fresh, execute migrate:fresh and seeders
     * - If not in production execute tests.
     *
     * @param iterable $epubFiles
     * @param bool     $isFresh
     * @param bool     $isDebug
     *
     * @return int
     */
    public function generate(iterable $epubFiles, bool $isFresh, ?bool $isDebug = false, ?bool $skip = false): int
    {
        $this->newLine();
        if ($isFresh) {
            // $this->info('The command was successful!');
            // $this->error('Something went wrong!');
            // $this->line('Display this on the screen');
            // $this->comment('Display this on the screen');
            // $this->alert('Run migrate:fresh...');
            // $this->newLine();

            $this->alert('Run migrate:fresh...');
            $command = 'migrate:fresh --force';
            Artisan::call($command, [], $this->getOutput());
            $clearIsSuccess = $this->clearAllMediaCollection();
            $clearIsSuccessText = null;
            $clearIsSuccess ? $clearIsSuccessText = 'success' : $clearIsSuccessText = 'failed';
            try {
                Artisan::call('db:seed --class RoleSeeder', [], $this->getOutput());
                Artisan::call('db:seed --class UserSeeder', [], $this->getOutput());
            } catch (\Throwable $th) {
                //throw $th;
            }
            $this->newLine();
            $this->alert("Clearing media... $clearIsSuccessText!");
            $this->info("Clear all files into 'public/storage/media' manage by spatie/laravel-medialibrary");
        }

        $books_with_covers = $this->generateBooks(epubFiles: $epubFiles, isDebug: $isDebug);
        $this->generateCovers(books_with_covers: $books_with_covers, isDebug: $isDebug);

        // Series tags
        $series = Serie::all();
        foreach ($series as $key => $serie) {
            $tags = [];
            foreach ($serie->books as $key => $book) {
                foreach ($book->tags as $key => $tag) {
                    if (! in_array($tag->slug, $tags, true)) {
                        array_push($tags, $tag->slug);
                    }
                }
            }
            foreach ($tags as $key => $tag) {
                $tag_model = Tag::whereSlug($tag)->first();
                $serie->tags()->save($tag_model);
            }
            $serie->save();
        }
        // -----

        if ('production' !== config('app.env') && ! $isDebug && ! $skip) {
            $this->alert('Run tests...');
            Artisan::call('pest:run');
        }

        if ($isFresh) {
            $this->alert('Run seeders...');
            $command = 'db:seed --force';
            Artisan::call($command, [], $this->getOutput());
        }

        $this->newLine();
        $this->table(
            ['Books', 'Series', 'Authors'],
            [[Book::count(), Serie::count(), Author::count()]]
        );
        $this->newLine();

        $this->info('Done!');

        $booksGenerated = count($books_with_covers);

        return $booksGenerated;
    }

    /**
     * Generate images for models
     * - Books covers from original extract cover
     * - Authors pictures from Wikipedia with their names
     * - Series covers from volume 01 of their Books relation if exists
     *  - option: add a JPG file to database/seeders/media/series with series slug name to set custom cover.
     *
     * @param iterable $books_with_covers
     * @param bool     $isDebug
     *
     * @return void
     */
    public function generateCovers(iterable $books_with_covers, bool $isDebug = false)
    {
        $format = strtoupper(config('bookshelves.cover_extension'));
        $this->newLine();
        $this->alert('Generate covers...');
        $this->info('- Generate covers with differents dimensions');
        $this->info("- $format format: original from EPUB, thumbnail");
        if (! $isDebug) {
            $this->info('- Open Graph in JPG format');
        }
        $this->newLine();
        $cover_bar = $this->output->createProgressBar(count($books_with_covers));
        $cover_bar->start();
        foreach ($books_with_covers as $key => $metadata) {
            if (null !== $metadata['cover']) {
                CoverGenerator::run(metadata: $metadata, isDebug: $isDebug);
                $cover_bar->advance();
            }
        }

        $cover_bar->finish();
        $this->newLine(2);
        $this->info('Covers generated!');
        $this->newLine();

        $this->alert('Generate series covers and extra data...');
        $this->info('- Get cover of vol. 1 to associate picture to serie if exist');
        $this->info("- If a JPG file with slug of serie exist in 'database/seeders/media/series', it's will be this picture");
        $this->info('- Get description from Wikipedia: HTTP requests');
        $this->newLine();
        $series = Serie::all();
        $series_cover_bar = $this->output->createProgressBar(count($series));
        $series_cover_bar->start();
        foreach ($series as $key => $serie) {
            ExtraDataGenerator::generateSerieCover(serie: $serie);
            ExtraDataGenerator::generateSerieLanguage(serie: $serie);
            ExtraDataGenerator::generateSerieDescription(serie: $serie);
            $series_cover_bar->advance();
        }
        $series_cover_bar->finish();
        $this->newLine(2);
        $this->info('Series Covers generated!');
        $this->newLine();

        if (! $isDebug) {
            $this->alert('Generate authors pictures...');
            $this->info('- Get pictures and description from Wikipedia: HTTP requests');
            $this->newLine();
            $authors = Author::all();
            $authors_pictures = $this->output->createProgressBar(count($authors));
            $authors_pictures->start();
            foreach ($authors as $key => $author) {
                ExtraDataGenerator::generateAuthorData(author: $author);
                $authors_pictures->advance();
            }
            $authors_pictures->finish();
            $this->newLine();
            $this->newLine();
            $this->info('Authors Pictures generated!');
            $this->newLine();
        }
    }

    /**
     * Generate Book model from parsed epub files.
     * - If Book exist already, skip it.
     * - Use EpubParser to get data and create Book with relations.
     *
     * @param iterable $epubFiles
     * @param bool     $isDebug
     *
     * @return iterable
     */
    public function generateBooks(iterable $epubFiles, bool $isDebug = false): iterable
    {
        // Parse $epubsFiles[] to get metadata and
        // save each EPUB as Book model with relationships
        $epubsCount = sizeof($epubFiles);
        $this->newLine();
        $this->alert("EPUB files detected: $epubsCount");
        $this->info('- Generate Book model with relationships');
        $this->info('- Generate new EPUB file with standard name');
        if (! $isDebug) {
            $this->info('- Get extra data from Google Books API: HTTP requests');
        }
        $this->newLine();
        $books_with_covers = [];
        $books_with_errors = [];

        // Extract metadata for each EPUB
        // Generate new EPUB file with standard name
        $epub_bar = $this->output->createProgressBar($epubsCount);
        $epub_bar->start();
        foreach ($epubFiles as $key => $filePath) {
            $metadataExtractor = MetadataExtractor::run($filePath, $isDebug);
            if ($metadataExtractor) {
                $tryToFindBook = Book::whereSlug(Str::slug($metadataExtractor->title))->first();
                if (! $tryToFindBook) {
                    $book_created = ConvertMetadataExtractor::run(metadataExtractor: $metadataExtractor, is_debug: $isDebug);
                    EpubGenerator::run(book: $book_created, file_path: $filePath);

                    array_push($books_with_covers, [
                        'book'            => $book_created,
                        'cover'           => $metadataExtractor->cover,
                        'cover_extension' => $metadataExtractor->cover_extension,
                    ]);
                }
            }
            $epub_bar->advance();
        }
        $epub_bar->finish();
        $this->newLine();
        $this->newLine();
        $this->info('EPUB files parsed and generated!');
        if (! empty($books_with_errors)) {
            $this->newLine();
            $this->warn('You have '.sizeof($books_with_errors).' fatal errors: XML file failed to be parsed');
            foreach ($books_with_errors as $key => $book) {
                $this->info($book);
            }
        }

        return $books_with_covers;
    }

    /**
     * Clear all media collection manage by spatie/laravel-medialibrary.
     *
     * @return bool
     */
    public function clearAllMediaCollection(): bool
    {
        $isSuccess = false;
        try {
            $books = Book::all();
            $series = Serie::all();
            $authors = Author::all();
            $books->each(function ($query) {
                $query->clearMediaCollection('books');
                $query->clearMediaCollection('epubs');
            });
            $series->each(function ($query) {
                $query->clearMediaCollection('series');
            });
            $authors->each(function ($query) {
                $query->clearMediaCollection('authors');
            });
            $isSuccess = true;
        } catch (\Throwable $th) {
            //throw $th;
        }
        Storage::disk('public')->deleteDirectory('media');

        return $isSuccess;
    }

    /**
     * DEPRECATED
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

            $book_epub_path = 'media/epubs';
            File::cleanDirectory(public_path('storage/media/epubs'));
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

    /**
     * For debug only, print each Book entity.
     *
     * @param Book $book
     * @param int  $key
     *
     * @return void
     */
    public function printEbook(Book $book, int $key)
    {
        $serie = null;
        if (null !== $book->serie) {
            $serie = $book->serie;
            $serie = $serie->title;
            $serie = $serie.' '.$book->volume.' - ';
        }
        $this->info($key.' '.$serie.$book->title);
    }
}
