<?php

namespace App\Console\Commands\Bookshelves;

use Spatie\Tags\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Providers\EbookParserEngine\EbooksList;
use App\Providers\EbookParserEngine\EbookParserEngine;
use App\Providers\BookshelvesConverterEngine\BookshelvesConverterEngine;

class BooksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:books
                            {--L|local : prevent external HTTP requests to public API for additional informations}
                            {--f|fresh : reset current books and relation, keep users}
                            {--l|limit= : limit epub files to generate, useful for debug}
                            {--d|debug : generate metadata files into public/storage/debug for debug}
                            {--D|default : use default cover for all (skip covers step)}';

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
        $app = config('app.name');
        $limit = str_replace('=', '', $this->option('limit'));
        $limit = intval($limit);
        $local = $this->option('local') ?? false;
        $fresh = $this->option('fresh') ?? false;
        $debug = $this->option('debug') ?? false;
        $default = $this->option('default') ?? false;

        Artisan::call('bookshelves:clear', [], $this->getOutput());
        $list = EbooksList::getEbooks(limit: $limit);

        if ($fresh) {
            Artisan::call('setup:database', [
                '--books'   => $fresh,
            ], $this->getOutput());
        }

        $this->alert("$app: books & relations");
        $this->comment('EPUB files detected: ' . sizeof($list));
        $this->info('- Generate Book model with relationships: Author, Tag, Publisher, Language, Serie, Identifier');
        $this->info('- Generate new EPUB file with standard name');
        $this->newLine();
        if (! $default) {
            $format = config('bookshelves.cover_extension');
            $this->comment('Generate covers for books and series (--default|-D to skip)');
            $this->info('- Generate covers with differents dimensions');
            $this->info("- Main format: $format (original from EPUB, thumbnail)");
            $this->info('- OpenGraph, Simple format: JPG (social, Catalog)');
            $this->newLine();
        }
        
        $genres = config('bookshelves.genres');
        foreach ($genres as $key => $genre) {
            Tag::findOrCreate($genre, 'genre');
        }
        $bar = $this->output->createProgressBar(sizeof($list));
        $bar->start();
        foreach ($list as $key => $epub) {
            $epe = EbookParserEngine::create($epub, $debug);
            if ($debug) {
                $this->info($key . ' ' . $epe->title);
            }
            $bce = BookshelvesConverterEngine::create($epe, $local, $default);

            if (! $debug) {
                $bar->advance();
            }
        }
        $bar->finish();
        $this->newLine();

        // if (! $fresh) {
        //     $this->warn('No fresh, scan for new eBooks');
        //     $this->newLine();
        //     $epubFiles = $this->getOnlyNewBooks($epubFiles, $debug);
        // }
        // $this->newLine(2);

        /*
         * Books
         */
        // $books = $this->books($epubFiles, $local, $debug);

        /*
         * Books covers
         */
        // if (! $default) {
        //     $this->covers($books);
        // }

        return true;
    }
}
