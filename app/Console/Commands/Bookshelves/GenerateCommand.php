<?php

namespace App\Console\Commands\Bookshelves;

use Artisan;
use Illuminate\Console\Command;

class GenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:generate
                            {--e|erase : erase all data}
                            {--f|fresh : reset current books and relation, keep users}
                            {--F|force : skip confirm question for prod}
                            {--L|local : prevent external HTTP requests to public API for additional informations}
                            {--d|debug : generate metadata files into public/storage/debug for debug}
                            {--b|books : assets for books}
                            {--a|authors : assets for authors}
                            {--s|series : assets for series}
                            {--l|limit= : limit epub files to generate, useful for debug}
                            {--D|default : use default cover for all (skip covers step)}
                            {--C|comments : sample command for comments}
                            {--S|selection : sample command for selection}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute bookshelves commands: books, assets, stats and sample.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $app = config('app.name');
        $this->newLine();
        $this->alert("{$app}: generate");

        $this->info('This tool will generate EPUB files and cover optimized files from EPUB files in storage/data/books...');
        $this->info("Original EPUB files will not be deleted but they won't be used after current parsing.");
        $this->newLine();

        // setup options
        $isForce = $this->option('force') ?? false;
        $fresh = $this->option('fresh') ?? false;
        $books = $this->option('books') ?? false;
        $authors = $this->option('authors') ?? false;
        $series = $this->option('series') ?? false;
        $erase = $this->option('erase') ?? false;
        $limit = $this->option('limit');
        $limit = str_replace('=', '', $limit);
        $limit = intval($limit);
        $local = $this->option('local') ?? false;
        $debug = $this->option('debug') ?? false;
        $default = $this->option('default');
        $comments = $this->option('comments') ?? false;
        $selection = $this->option('selection') ?? false;

        if ($fresh) {
            $this->warn('- Option --fresh: erase current database, migrate and seed basics also clear all medias.');
        }
        if ($erase) {
            $this->warn('- Option --erase: erase all data.');
        }
        if ($limit) {
            $this->warn("- Option --limit: limit eBooks generated to {$limit}.");
        }
        if ($local) {
            $this->warn('- Option --local: skip HTTP requests.');
        }
        if ($debug) {
            $this->warn('- Option --debug: generate metadata files into public/storage/debug for debug.');
        }
        if ($books) {
            $this->warn('- Option --books: generate assets for authors from GoogleBook.');
        }
        if ($authors) {
            $this->warn('- Option --authors: generate assets for authors from Wikipedia.');
        }
        if ($series) {
            $this->warn('- Option --series: generate assets for series from Wikipedia.');
        }
        if ($default) {
            $this->warn('- Option --default: skip covers step, use default cover.');
        }
        if ($comments) {
            $this->warn('- Option --comments: generate comments and favorites for fake users.');
        }
        if ($selection) {
            $this->warn('- Option --selection: generate selection for home slider.');
        }
        $this->newLine();

        if ($erase) {
            Artisan::call('migrate:fresh --force', [], $this->getOutput());
            $this->newLine();
        }

        $isProd = 'local' !== config('app.env') ? true : false;
        if ($isProd && ! $isForce) {
            if (! $this->confirm('You are in production environement, do you want really continue?')) {
                return;
            }
        }

        /*
         * Generate commands
         */
        Artisan::call('bookshelves:books', [
            '--local' => $local,
            '--fresh' => $fresh,
            '--limit' => $limit,
            '--debug' => $debug,
            '--default' => $default,
        ], $this->getOutput());
        Artisan::call('bookshelves:assets', [
            '--books' => $books,
            '--authors' => $authors,
            '--series' => $series,
            '--local' => $local,
            '--fresh' => $fresh,
            '--default' => $default,
        ], $this->getOutput());

        Artisan::call('bookshelves:stats', [], $this->getOutput());
        $this->newLine();

        if (! $debug) {
            Artisan::call('bookshelves:clear', [], $this->getOutput());
        }

        Artisan::call('bookshelves:sample', [
            '--admin' => true,
            '--selection' => $selection,
            '--comments' => $comments,
            '--force' => $isForce,
        ], $this->getOutput());

        $this->info('Done!');
    }
}
