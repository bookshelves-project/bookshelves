<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\ExternalApiProcess;
use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;
use Kiwilan\Steward\Services\DirectoryService;

/**
 * Extra data for Book, Author, Serie.
 */
class ApiCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:api
                            {--b|books : assets for books}
                            {--a|authors : assets for authors}
                            {--s|series : assets for series}
                            {--f|fresh : refresh authors medias, `description` & `link`}
                            {--D|default : use default cover for all (skip covers step)}
                            {--F|force : skip confirm in prod}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate data for Books, Authors, Series from public API.';

    protected bool $fresh = false;

    protected bool $verbose = false;

    protected bool $default = false;

    /**
     * Create a new command instance.
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
        $this->title();

        $this->askOnProduction();

        DirectoryService::make()
            ->clear([storage_path('app/public/debug/wikipedia')])
        ;

        $authors = $this->option('authors') ?: false;
        $series = $this->option('series') ?: false;
        $books = $this->option('books') ?: false;

        $this->fresh = $this->option('fresh') ?: false;
        $this->verbose = $this->option('verbose') ?: false;
        $this->default = $this->option('default') ?: false;

        if ($this->verbose) {
            $this->newLine();
            $this->info('Verbose mode');
            $this->info('All requests will be printed as JSON into `public/storage/debug/wikipedia` directory.');
            $this->newLine();
        }

        ExternalApiProcess::dispatch($books, $authors, $series, $this->verbose);

        return Command::SUCCESS;
    }
}
