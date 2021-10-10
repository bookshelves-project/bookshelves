<?php

namespace App\Console\Commands\Bookshelves;

use App\Providers\ConverterEngine\ConverterEngine;
use App\Providers\ParserEngine\ParserEngine;
use App\Providers\ParserEngine\ParserList;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Spatie\Tags\Tag;

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
        $list = ParserList::getEbooks(limit: $limit);

        if ($fresh) {
            Artisan::call('setup:database', [
                '--books' => $fresh,
            ], $this->getOutput());
        }

        $this->alert("{$app}: books & relations");
        $this->comment('EPUB files detected: '.sizeof($list));
        $this->info('- Generate Book model with relationships: Author, Tag, Publisher, Language, Serie, Identifier');
        $this->info('- Generate new EPUB file with standard name');
        $this->newLine();
        if (! $default) {
            $format = config('bookshelves.cover_extension');
            $this->comment('Generate covers for books (--default|-D to skip)');
            $this->info('- Generate covers with differents dimensions');
            $this->info("- Main format: {$format} (original from EPUB, thumbnail)");
            $this->info('- OpenGraph, Simple format: JPG (social, Catalog)');
            if ('local' === config('app.env')) {
                $this->info('You are in local, conversions are generate only in production');
            }
            $this->newLine();
        }

        $genres = config('bookshelves.tags.genres_list');
        foreach ($genres as $key => $genre) {
            Tag::findOrCreate($genre, 'genre');
        }

        $start = microtime(true);

        $bar = $this->output->createProgressBar(sizeof($list));
        $bar->start();
        foreach ($list as $key => $epub) {
            $parser = ParserEngine::create($epub, $debug);
            if ($debug) {
                $this->info($key.' '.$parser->title);
            }
            ConverterEngine::create($parser, $local, $default);

            if (! $debug) {
                $bar->advance();
            }
        }
        $bar->finish();
        $this->newLine();

        $this->newLine();
        $time_elapsed_secs = number_format(microtime(true) - $start, 2);
        $this->info("Time in seconds: {$time_elapsed_secs}");

        return true;
    }
}
