<?php

namespace App\Console\Commands;

use App\Models\Author;
use File;
use Artisan;
use Storage;
use App\Models\Book;
use App\Models\Identifier;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Serie;
use App\Models\Tag;
use App\Providers\EpubGenerator\EpubGenerator;
use App\Providers\EpubParser\Entities\IdentifiersParser;
use App\Providers\EpubParser\EpubParser;
use App\Providers\EpubParser\EpubParserTools;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BooksGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:generate
                            {--f|fresh : reset current database to fresh install}
                            {--d|debug : default author pictures, basic covers only}
                            {--F|force : skip confirm question for fresh prod}';

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
    public function handle()
    {
        // Artisan::call('log:clear');
        

        // setup options
        $isDebug = $this->option('debug');
        $isForce = $this->option('force');
        $isFresh = $this->option('fresh');

        // $message = 'message';

        // $process = new Process(['echo "" > storage/logs/epubparser.log']);
        // $process->setTimeout(0);
        // $process->start();
        // $iterator = $process->getIterator($process::ITER_SKIP_ERR | $process::ITER_KEEP_OUTPUT);
        // foreach ($iterator as $data) {
        //     echo $data;
        // }



        // Log::channel('epubparser')->emergency($message);
        // Log::channel('epubparser')->alert($message);
        // Log::channel('epubparser')->critical($message);
        // Log::channel('epubparser')->error($message);
        // Log::channel('epubparser')->warning($message);
        // Log::channel('epubparser')->notice($message);
        // Log::channel('epubparser')->info($message);
        // Log::channel('epubparser')->debug($message);

        // $logFile = file(storage_path("/logs/epubparser.log"));
        // // dump($logFile);
        // $logCollection = [];
        // // Loop through an array, show HTML source as HTML source; and line numbers too.
        // foreach ($logFile as $line_num => $line) {
        //     $log = explode(' ', $line);
        //     // dump($log);
        //     $date = str_replace('[', '', $log[0]);
        //     $time = str_replace(']', '', $log[1]);
        //     $type = str_replace(':', '', $log[2]);
        //     $type = str_replace('local.', '', $type);
        //     $message = $log[3];
        //     array_push($logCollection, [
        //         'date' => $date,
        //         'time' => $time,
        //         'type' => $type,
        //         'message' => $message
        //     ]);
        // }
        // $this->alert('alert');
        // $this->warn('warn');
        // $this->error('error');
        // $this->info('info');
        // dump($logCollection);

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
        $epubFiles = EpubParserTools::getAllEpubFiles();

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
            $this->warn("Basic parsing isn't ready, try fresh parsing with option --fresh");

            $this->generate(epubFiles: $epubFiles, isFresh: $isFresh, isDebug: $isDebug);
        }
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
            Artisan::call('migrate:fresh --seed --force');
            $this->clearDirectories();
        }

        $books_with_covers = $this->generateBooks(epubFiles: $epubFiles, isDebug: $isDebug);
        $this->generateCovers(books_with_covers: $books_with_covers, isDebug: $isDebug);
        Artisan::call('pest:run');
        
        $this->info('Done!');
    }

    public function generateCovers(array $books_with_covers, bool $isDebug = false)
    {
        $this->info("\n".'Generate covers'."\n");
        $cover_bar = $this->output->createProgressBar(count($books_with_covers));
        $cover_bar->start();
        foreach ($books_with_covers as $key => $metadata) {
            EpubGenerator::extractCoverAndGenerate($metadata, $isDebug);
            $cover_bar->advance();
        }
        $cover_bar->finish();
        $this->info("\n");
        $this->info('Covers generated!'."\n");

        File::cleanDirectory(public_path('storage/covers/raw'));
        Storage::disk('public')->copy('.gitignore-sample', 'covers/raw/.gitignore');
    }

    public function generateBooks(array $epubFiles, bool $isDebug = false)
    {
        // Parse $epubsFiles[] to get metadata and
        // save each EPUB as Book model with relationships
        $epubsCount = sizeof($epubFiles);
        $this->info("\nEPUB files detected: $epubsCount\n");
        $books_with_covers = [];
        $books_with_errors = [];

        // Extract metadata for each EPUB
        // Generate new EPUB file with standard name
        $epub_bar = $this->output->createProgressBar($epubsCount);
        $epub_bar->start();
        foreach ($epubFiles as $key => $filePath) {
            $epubParser = EpubParser::run($filePath, $isDebug);
            $book_created = EpubGenerator::convertEpubParser(epubParser: $epubParser, is_debug: $isDebug);
            $epub_created = EpubGenerator::generateNewEpub(book: $book_created, file_path: $filePath);
            $book_created->epub()->associate($epub_created);
            $book_created->save();
            // $epub->book()->save($book);
            // $epub->save();
            // dump($epubParser->title);
            // if (is_array($book_with_cover) && array_key_exists('book', $book_with_cover)) {
            //     array_push($books_with_covers, $book_with_cover);
            // } else {
            //     array_push($books_with_errors, $book_with_cover);
            // }
            array_push($books_with_covers, [
                'book' => $book_created,
                'cover' => $epubParser->cover,
                'cover_extension' =>$epubParser->cover_extension
            ]);
            $epub_bar->advance();
        }
        $epub_bar->finish();
        $this->info("\n");
        $this->info('EPUB files parsed and generated!');
        if (sizeof($books_with_errors) >= 1) {
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
            File::cleanDirectory(public_path('storage/authors'));
            Storage::disk('public')->copy('.gitignore-sample', 'authors/.gitignore');
            Storage::disk('public')->copy('no-picture.jpg', 'authors/no-picture.jpg');

            // Dir for thumbnails 240 x 320 and optimize
            File::cleanDirectory(public_path('storage/covers/thumbnail'));
            Storage::disk('public')->copy('.gitignore-sample', 'covers/thumbnail/.gitignore');

            // Dir for covers resized 480 x 640 and optimize
            File::cleanDirectory(public_path('storage/covers/basic'));
            Storage::disk('public')->copy('.gitignore-sample', 'covers/basic/.gitignore');

            // Dir for original covers not resized but optimize
            File::cleanDirectory(public_path('storage/covers/original'));
            Storage::disk('public')->copy('.gitignore-sample', 'covers/original/.gitignore');

            // Dir for generated EPUB files from originals with new standard name
            File::cleanDirectory(public_path('storage/books'));
            Storage::disk('public')->copy('.gitignore-sample', 'books/.gitignore');
        } catch (\Throwable $th) {
            dump('Error on clearDirectories()');

            return false;
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
