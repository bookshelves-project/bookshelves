<?php

namespace App\Console\Commands\Bookshelves;

use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use App\Services\ConverterEngine\AuthorConverter;
use App\Services\ConverterEngine\SerieConverter;
use App\Services\GoogleBookService;
use App\Services\WikipediaService\WikipediaQuery;
use App\Services\WikipediaService\WikipediaService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

/**
 * Extra data for Book, Author, Serie.
 */
class AssetsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:assets
                            {--b|books : assets for books}
                            {--a|authors : assets for authors}
                            {--s|series : assets for series}
                            {--L|local : prevent external HTTP requests to public API for additional informations}
                            {--f|fresh : refresh authors medias, `description` & `link`}
                            {--D|default : use default cover for all (skip covers step)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate assets for Books, Authors, Series from public API.';

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
        $authors = $this->option('authors') ?? false;
        $series = $this->option('series') ?? false;
        $books = $this->option('books') ?? false;
        $local = $this->option('local') ?? false;
        $default = $this->option('default') ?? false;

        $app = config('app.name');
        $this->newLine();
        $this->alert("{$app}: assets");
        if ($books) {
            $this->comment('Books (REMOVE --books|-b to skip)');
            if (! $local) {
                $this->info('- GoogleBook: extract data to improve Book (--local|-L to skip)');
            }
            $this->newLine();

            $this->assets('Book', 'books', 'title_sort');
        }
        if ($authors) {
            $this->comment('Authors (REMOVE --authors|-a to skip)');
            if (! $local) {
                $this->info('- Picture from Wikipedia (--local|-L to skip)');
            }
            if (! $default) {
                $this->info('  - Default picture can be JPG file with slug of serie in `public/storage/data/pictures-authors` (--default|-D to skip)');
            }
            if (! $local) {
                $this->info('- Description from Wikipedia (--local|-L to skip)');
            }
            $this->info('  - Default description can be in `public/storage/data/authors.json`');
            $this->newLine();

            $this->assets('Author', 'authors', 'lastname');
        }
        if ($series) {
            $this->comment('Series (REMOVE --series|-s to skip)');
            $this->info('- Tags from all Books of Serie');
            if (! $default) {
                $this->info('- Picture from first Book of Serie (--default|-D to skip)');
            }
            $this->info('  - Default picture can be JPG file with slug of serie in `public/storage/data/pictures-series`');
            if (! $local) {
                $this->info('- Description from Wikipedia (--local|-L to skip)');
            }
            $this->info('  - Default description can be in `public/storage/data/series.json`');
            $this->newLine();

            $this->assets('Serie', 'series', 'title_sort');
        }

        return 0;
    }

    private function assets(string $model, string $collection, string $orderBy)
    {
        $books = $this->option('books') ?? false;
        $model_name = 'App\Models\\'.ucfirst($model);
        $list = $model_name::orderBy($orderBy)->get();
        $this->comment($model.': '.sizeof($list));

        $start = microtime(true);

        $this->{$collection}($list, $collection);

        $this->newLine();
        $time_elapsed_secs = number_format(microtime(true) - $start, 2);
        $this->info("Time in seconds: {$time_elapsed_secs}");

        $this->newLine();
    }

    private function books(Collection $list, string $collection)
    {
        $local = $this->option('local') ?? false;
        if (! $local) {
            $chunk = $list->chunk(config('http.pool_limit'));

            $this->info('HTTP requests with async splitted in '.config('http.pool_limit').' entities of '.sizeof($chunk).' chunks.');
            $this->newLine();

            foreach ($chunk as $key => $list) {
                $this->info('Fetching API data for chunk '.($key + 1));
                $providers = GoogleBookService::createAsync($list);
                $bar = $this->output->createProgressBar(count($list));
                $bar->start();
                foreach ($providers as $bookID => $provider) {
                    $book = Book::find($bookID);
                    $provider->convert()->improveBookData($book);
                    $bar->advance();
                }
                $bar->finish();
                $this->newLine();
            }
        }
    }

    private function authors(Collection $list, string $collection)
    {
        $fresh = $this->option('fresh') ?? false;
        $local = $this->option('local') ?? false;

        if ($fresh) {
            foreach ($list as $key => $model) {
                $model->clearMediaCollection($collection);
                $model->description = null;
                $model->link = null;
                $model->save();
            }
        }

        $service = WikipediaService::create(Author::class, 'name');
        /** @var WikipediaQuery $query */
        foreach ($service->wikipedia_queries as $query) {
            /** @var Author $author */
            $author = $query->model_name::find($query->model_id);
            $author->description = $query->extract;
            $author->link = $query->page_url;
            $author->save();
        }

        // if (! $local) {
        //     $this->authorsAsync($list, $collection);
        // } else {
        //     $bar = $this->output->createProgressBar(count($list));
        //     $bar->start();
        //     foreach ($list as $key => $model) {
        //         AuthorConverter::setLocalPicture($model);
        //         $bar->advance();
        //     }
        //     $bar->finish();
        // }
    }

    private function authorsAsync(Collection $list, string $collection)
    {
        $default = $this->option('default') ?? false;

        $this->info('HTTP requests with async...');
        $this->info('Progress bar is not available with async');

        // $providers = WikipediaService::make($list, 'name');
        // $this->newLine();

        // $this->info('Set async data');
        // $bar = $this->output->createProgressBar(count($list));
        // $bar->start();
        // foreach ($providers as $key => $provider) {
        //     $model = $provider->model_name::find($provider->model_id);

        //     /** @var Author $model */
        //     // if (! $model->description && ! $model->link) {
        //     //     AuthorConverter::setWikiDescription($model, $provider);
        //     //     if (! $default) {
        //     //         AuthorConverter::setWikiPicture($model, $provider);
        //     //     }
        //     // }
        //     $bar->advance();
        // }
        // $bar->finish();
    }

    private function series(Collection $list, string $collection)
    {
        $fresh = $this->option('fresh') ?? false;
        $local = $this->option('local') ?? false;
        $default = $this->option('default') ?? false;

        if ($fresh) {
            foreach ($list as $key => $model) {
                $model->clearMediaCollection($collection);
                $model->description = null;
                $model->link = null;
                $model->save();
            }
        }

        if (! $local) {
            // $this->seriesAsync($list, $collection);
            $service = WikipediaService::create(Serie::class, 'title');
            /** @var WikipediaQuery $query */
            foreach ($service->wikipedia_queries as $query) {
                /** @var Serie $serie */
                $serie = $query->model_name::find($query->model_id);
                $serie->description = $query->extract;
                $serie->link = $query->page_url;
                $serie->save();
            }
        }

        $this->newLine(2);
        $this->info('Set tags and covers');
        $bar = $this->output->createProgressBar(count($list));
        $bar->start();
        foreach ($list as $key => $model) {
            SerieConverter::setTags($model);
            if (! $default) {
                SerieConverter::setCover($model);
            }
            $bar->advance();
        }
        $bar->finish();
    }

    private function seriesAsync(Collection $list, string $collection)
    {
        // $this->info('HTTP requests with async...');
        // $this->info('Progress bar is not available with async');
        // $providers = WikipediaService::make($list, 'title');
        // $this->newLine();

        // $this->info('Set async data');
        // $bar = $this->output->createProgressBar(count($list));
        // $bar->start();
        // foreach ($providers as $key => $provider) {
        //     $model = $provider->model_name::find($provider->model_id);

        //     /** @var Serie $model */
        //     if (! $model->description && ! $model->link) {
        //         SerieConverter::setWikiDescription($model, $provider);
        //     }
        //     $bar->advance();
        // }
        // $bar->finish();
        // $this->newLine();
    }
}
