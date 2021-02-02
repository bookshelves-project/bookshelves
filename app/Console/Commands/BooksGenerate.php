<?php

namespace App\Console\Commands;

use DB;
use File;
use Artisan;
use Storage;
use App\Utils\EpubParser;
use InvalidArgumentException;
use Illuminate\Console\Command;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use Illuminate\Contracts\Container\BindingResolutionException;

class BooksGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:generate {--fresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate books database from storage/books-raw';

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
        $fresh = $this->option('fresh');
        if ($fresh) {
            $this->info('Generate books from storage/books-raw...');

            // Apply storage:link if not set
            Artisan::call('storage:link');
            // Clear database and set seeders
            Artisan::call('migrate:fresh --seed --force');
            // Clear all directories
            $this->clearDirectories();

            // Get all files in books-raw/
            $files = Storage::disk('public')->allFiles('books-raw');
            $epubsFiles = [];
            // Get EPUB files form books-raw/ and create new $epubsFiles[]
            foreach ($files as $key => $value) {
                if (array_key_exists('extension', pathinfo($value)) && 'epub' === pathinfo($value)['extension']) {
                    array_push($epubsFiles, $value);
                }
            }

            // Parse $epubsFiles[] to get metadata and
            // save each EPUB as Book model with relationships
            $this->info("\n".'EPUB files: '.sizeof($epubsFiles)."\n");
            $metadataEntities = [];
            $epub_bar = $this->output->createProgressBar(count($epubsFiles));
            $this->output->progressStart(10);
            foreach ($epubsFiles as $key => $file) {
                // get metadata from EPUB file
                $metadata = EpubParser::getMetadata($file);
                $book = $metadata['book'];
                // generate new EPUB file with standard name from original
                EpubParser::generateNewEpub($book, $file);
                // Print each Book
                // $serie = null;
                // if (null !== $book->serie) {
                //     $serie = $book->serie;
                //     $serie = $serie->title;
                //     $serie = $serie.' '.$book->serie_number.' - ';
                // }
                // $this->info($key.' '.$serie.$book->title);
                array_push($metadataEntities, $metadata);
                $epub_bar->advance();
            }
            $epub_bar->finish();
            $this->info("\n".'EPUB files parsed an generated!'."\n");

            // Generate covers
            $this->info('Generate covers'."\n");
            $cover_bar = $this->output->createProgressBar(count($metadataEntities));
            $this->output->progressStart(10);
            foreach ($metadataEntities as $key => $metadata) {
                $book = $metadata['book'];
                $cover_extension = $metadata['cover_extension'];
                EpubParser::generateCovers($book, $cover_extension);
                $cover_bar->advance();
            }
            $cover_bar->finish();
            $this->info("\n");
            $this->info('Covers generated!'."\n");

            // Clean temporary covers-raw/
            // File::cleanDirectory(public_path('storage/covers-raw'));
            // Regenerate .gitignore from covers-raw/
            // Storage::disk('public')->copy('.gitignore-sample', 'covers-raw/.gitignore');

            $this->info('Done!');
        }
    }

    /**
     * Clean directories with generated covers and EPUB files
     * Don't erase original EPUB files.
     *
     * @throws BindingResolutionException
     * @throws InvalidArgumentException
     * @throws FileExistsException
     * @throws FileNotFoundException
     *
     * @return bool[]
     */
    public function clearDirectories()
    {
        // Dir for thumbnails 240 x 320 and optimize
        $cacheClean = File::cleanDirectory(public_path('storage/cache'));
        $cacheGitignore = Storage::disk('public')->copy('.gitignore-sample', 'cache/.gitignore');

        // Dir for covers resized 480 x 640 and optimize
        $coversBasicClean = File::cleanDirectory(public_path('storage/covers-basic'));
        $coversBasicGitignore = Storage::disk('public')->copy('.gitignore-sample', 'covers-basic/.gitignore');

        // Dir for original covers not resized but optimize
        $coversOriginalClean = File::cleanDirectory(public_path('storage/covers-original'));
        $coversOriginalGitignore = Storage::disk('public')->copy('.gitignore-sample', 'covers-original/.gitignore');

        // Dir for generated EPUB files from originals with new standard name
        $booksClean = File::cleanDirectory(public_path('storage/books'));
        $booksCleanGitignore = Storage::disk('public')->copy('.gitignore-sample', 'books/.gitignore');

        return [
            'cache'           => $cacheClean && $cacheGitignore,
            'covers-basic'    => $coversBasicClean && $coversBasicGitignore,
            'covers-original' => $coversOriginalClean && $coversOriginalGitignore,
            'books'           => $booksClean && $booksCleanGitignore,
        ];
    }

    /**
     * DEPRECATE.
     */
    public function refreshDB(string $table)
    {
        $max = DB::table($table)->max('id') + 1;
        DB::statement("ALTER TABLE $table AUTO_INCREMENT =  $max");
    }
}
