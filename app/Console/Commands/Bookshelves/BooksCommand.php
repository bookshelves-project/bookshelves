<?php

namespace App\Console\Commands\Bookshelves;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Providers\EbookParserEngine\EbooksList;
use App\Providers\EbookParserEngine\EbookParserEngine;
use App\Providers\BookshelvesConverter\BookshelvesConverter;

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
        $limit = str_replace('=', '', $this->option('limit'));
        $limit = intval($limit);
        $local = $this->option('local') ?? false;
        $fresh = $this->option('fresh') ?? false;
        $debug = $this->option('debug') ?? false;
        $default = $this->option('default') ?? false;

        $list = EbooksList::getEbooks(limit: $limit);

        if ($fresh) {
            Artisan::call('setup:database', [
                '--books'   => $fresh,
            ], $this->getOutput());
        }

        $bar = $this->output->createProgressBar(sizeof($list));
        $bar->start();
        foreach ($list as $epub) {
            $EPE = EbookParserEngine::create($epub, $limit, $debug, true);
            $book = BookshelvesConverter::create($EPE, $local);
            // dump($EPE);
            $bar->advance();
        }
        $bar->finish();

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
