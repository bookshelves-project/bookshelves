<?php

namespace App\Console\Commands\Bookshelves;

use Str;
use App\Models\Book;
use Illuminate\Console\Command;
use App\Providers\Bookshelves\EpubGenerator;
use App\Providers\MetadataExtractor\MetadataExtractor;
use App\Providers\Bookshelves\ConvertMetadataExtractor;
use App\Providers\MetadataExtractor\MetadataExtractorTools;

class BooksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bs:books
                            {--l|limit= : limit epub files to generate, useful for debug}';

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
        $limit = $this->option('limit');
        $limit = str_replace('=', '', $limit);
        $limit = intval($limit);
        $epubFiles = MetadataExtractorTools::getAllEpubFiles(limit: $limit);

        $this->alert('Bookshelves: books');
        $this->comment('EPUB files detected: '.sizeof($epubFiles));
        $this->info('- Generate Book model with relationships');
        $this->info('- Generate new EPUB file with standard name');
        $this->info('- Get extra data from Google Books API: HTTP requests');
        $this->newLine();

        $metadataExtractorArray = [];

        $epub_bar = $this->output->createProgressBar(sizeof($epubFiles));
        $epub_bar->start();
        foreach ($epubFiles as $key => $filePath) {
            $metadataExtractor = MetadataExtractor::run($filePath);
            if ($metadataExtractor) {
                $tryToFindBook = Book::whereSlug(Str::slug($metadataExtractor->title))->first();
                if (! $tryToFindBook) {
                    $new_book = ConvertMetadataExtractor::run(metadataExtractor: $metadataExtractor);
                    EpubGenerator::run(book: $new_book, filePath: $filePath);
                    array_push($metadataExtractorArray, $metadataExtractor);
                }
            }
            $epub_bar->advance();
        }
        $epub_bar->finish();
        $this->newLine(2);

        return 0;
    }
}
