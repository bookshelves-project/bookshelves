<?php

namespace App\Console\Commands\Bookshelves;

use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use App\Services\ConverterEngine\AuthorConverter;
use App\Services\ConverterEngine\SerieConverter;
use App\Services\GoogleBookService\GoogleBookQuery;
use App\Services\GoogleBookService\GoogleBookService;
use App\Services\WikipediaService\WikipediaQuery;
use App\Services\WikipediaService\WikipediaService;
use App\Utils\ClearFileTools;
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
                            {--d|debug : print log for debug}
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
        $debug = $this->option('debug') ?? false;

        $tool = new ClearFileTools(storage_path('app/public/debug/wikipedia'));
        $tool->clearDir();

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
        $fresh = $this->option('fresh') ?? false;
        $debug = $this->option('debug') ?? false;

        if (! $local) {
            if ($fresh) {
                /** @var Book $model */
                foreach ($list as $key => $model) {
                    if ($model->googleBook) {
                        $model->googleBook->delete();
                    }
                }
            }

            $service = GoogleBookService::create(Book::class, debug: $debug);

            $bar = $this->output->createProgressBar(count($service->queries));
            $bar->start();
            /** @var GoogleBookQuery $query */
            foreach ($service->queries as $query) {
                /** @var Book $model */
                $model = $query->model_name::find($query->model_id);
                $query->convert();
                $bar->advance();
            }
            $bar->finish();
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

        if (! $local) {
            $default = $this->option('default') ?? false;
            $debug = $this->option('debug') ?? false;

            $service = WikipediaService::create(Author::class, 'name', debug: $debug);
            $this->newLine();

            $bar = $this->output->createProgressBar(count($service->queries));
            $bar->start();
            /** @var WikipediaQuery $query */
            foreach ($service->queries as $query) {
                /** @var Author $model */
                $model = $query->model_name::find($query->model_id);
                if (! $model->description && ! $model->link) {
                    AuthorConverter::setWikiDescription($model, $query);
                    if (! $default) {
                        AuthorConverter::setWikiPicture($model, $query);
                    }
                }
                $bar->advance();
            }
            $bar->finish();
        } else {
            $bar = $this->output->createProgressBar(count($list));
            $bar->start();
            foreach ($list as $key => $model) {
                AuthorConverter::setLocalPicture($model);
                $bar->advance();
            }
            $bar->finish();
        }
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
            $debug = $this->option('debug') ?? false;

            $service = WikipediaService::create(Serie::class, 'title', debug: $debug);

            $this->info('Set extra content');
            $bar = $this->output->createProgressBar(count($service->queries));
            $bar->start();
            /** @var WikipediaQuery $query */
            foreach ($service->queries as $query) {
                /** @var Serie $model */
                $model = $query->model_name::find($query->model_id);
                if (! $model->description && ! $model->link) {
                    SerieConverter::setWikiDescription($model, $query);
                }
                $bar->advance();
            }
            $bar->finish();
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
}
