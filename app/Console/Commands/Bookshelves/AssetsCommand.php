<?php

namespace App\Console\Commands\Bookshelves;

use App\Console\CommandProd;
use App\Engines\ConverterEngine\AuthorConverter;
use App\Engines\ConverterEngine\SerieConverter;
use App\Enums\MediaDiskEnum;
use App\Models\Author;
use App\Models\Book;
use App\Models\GoogleBook;
use App\Models\Serie;
use App\Models\WikipediaItem;
use App\Services\DirectoryClearService;
use App\Services\GoogleBookService;
use App\Services\WikipediaService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

/**
 * Extra data for Book, Author, Serie.
 */
class AssetsCommand extends CommandProd
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
                            {--D|default : use default cover for all (skip covers step)}
                            {--F|force : skip confirm in prod}';

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
     * @return bool
     */
    public function handle()
    {
        $this->checkProd();

        $service = new DirectoryClearService(storage_path('app/public/debug/wikipedia'));
        $service->clearDir();

        $this->intro();

        $authors = $this->option('authors') ?? false;
        $series = $this->option('series') ?? false;
        $books = $this->option('books') ?? false;
        $local = $this->option('local') ?? false;
        $default = $this->option('default') ?? false;

        if ($books) {
            // $this->comment('Books (REMOVE --books|-b to skip)');
            // if (! $local) {
            //     $this->info('- GoogleBook: extract data to improve Book (--local|-L to skip)');
            // }
            // $this->newLine();

            $this->assets('Book', 'books', 'slug_sort');
        }
        if ($authors) {
            // $this->comment('Authors (REMOVE --authors|-a to skip)');
            // if (! $local) {
            //     $this->info('- Picture from Wikipedia (--local|-L to skip)');
            // }
            // if (! $default) {
            //     $this->info('  - Default picture can be JPG file with slug of serie in `public/storage/data/authors` (--default|-D to skip)');
            // }
            // if (! $local) {
            //     $this->info('- Description from Wikipedia (--local|-L to skip)');
            // }
            // $this->info('  - Default description can be in `public/storage/data/authors/authors.json`');
            // $this->newLine();

            $this->assets('Author', 'authors', 'lastname');
        }
        if ($series) {
            // $this->comment('Series (REMOVE --series|-s to skip)');
            // $this->info('- Tags from all Books of Serie');
            // if (! $default) {
            //     $this->info('- Picture from first Book of Serie (--default|-D to skip)');
            // }
            // $this->info('  - Default picture can be JPG file with slug of serie in `public/storage/data/series`');
            // if (! $local) {
            //     $this->info('- Description from Wikipedia (--local|-L to skip)');
            // }
            // $this->info('  - Default description can be in `public/storage/data/series/series.json`');
            // $this->newLine();

            $this->assets('Serie', 'series', 'slug_sort');
        }

        return true;
    }

    private function assets(string $model, string $collection, string $orderBy)
    {
        $model_name = ucfirst($model);
        $model_name = "App\\Models\\{$model_name}";
        $list = $model_name::orderBy($orderBy)->get();
        $this->comment($model.': '.sizeof($list));

        $start = microtime(true);

        $this->{$collection}($list, $collection);

        $this->newLine();
        $time_elapsed_secs = number_format(microtime(true) - $start, 2);
        $this->newLine();
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
                GoogleBook::query()->delete();
            }

            $count = Book::whereNotNull('isbn10')
                ->orWhereNotNull('isbn13')
                ->count()
            ;
            $this->comment("Need to have ISBN, {$count} books can be scanned");
            $service = GoogleBookService::create(Book::class, debug: $debug);

            $this->newLine();
            if (0 === count($service->queries)) {
                $this->warn('All books have already a GoogleBook relationship, execute same command with --fresh option to erase GoogleBook.');

                return false;
            }

            $bar = $this->output->createProgressBar(count($service->queries));
            $bar->start();
            foreach (Book::has('googleBook')->get() as $book) {
                $book->googleBook->improveBook();
                $bar->advance();
            }
            $bar->finish();
        }

        return true;
    }

    private function authors(Collection $list, string $collection)
    {
        $fresh = $this->option('fresh') ?? false;
        $local = $this->option('local') ?? false;

        if ($fresh) {
            WikipediaItem::whereModel(Author::class)->delete();
            /** @var Author $model */
            foreach ($list as $model) {
                $model->clearMediaCollection(MediaDiskEnum::cover->value);
                $model->description = null;
                $model->link = null;
                $model->save();
            }
        }

        if (! $local) {
            $default = $this->option('default') ?? false;
            $debug = $this->option('debug') ?? false;

            $service = WikipediaService::create(Author::class, ['firstname', 'lastname'], debug: $debug);
            $this->newLine();

            $bar = $this->output->createProgressBar(count($service->queries));
            $bar->start();
            foreach (Author::has('wikipedia')->get() as $author) {
                AuthorConverter::setWikiDescription($author);
                if (! $default) {
                    AuthorConverter::setWikiPicture($author);
                }
                $bar->advance();
            }
            $bar->finish();
        } else {
            $bar = $this->output->createProgressBar(count($list));
            $bar->start();
            foreach ($list as $model) {
                /** @var Author $model */
                AuthorConverter::setLocalPicture($model);
                $bar->advance();
            }
            $bar->finish();
        }

        $this->newLine();
        $this->info('Add placeholder if not picture');
        $bar = $this->output->createProgressBar(count($list));
        $bar->start();
        foreach ($list as $model) {
            /** @var Author $model */
            AuthorConverter::setPicturePlaceholder($model);
            $bar->advance();
        }
        $bar->finish();
    }

    private function series(Collection $list, string $collection)
    {
        $fresh = $this->option('fresh') ?? false;
        $local = $this->option('local') ?? false;
        $default = $this->option('default') ?? false;

        if ($fresh) {
            WikipediaItem::whereModel(Serie::class)->delete();
            foreach ($list as $model) {
                $model->clearMediaCollection($collection);
                $model->description = null;
                $model->link = null;
                $model->save();
            }
        }

        if (! $local) {
            $debug = $this->option('debug') ?? false;

            $service = WikipediaService::create(Serie::class, 'title', debug: $debug);

            $this->newLine();
            $this->info('Set extra content');
            $bar = $this->output->createProgressBar(count($service->queries));
            $bar->start();
            foreach (Serie::has('wikipedia')->get() as $model) {
                SerieConverter::setWikiDescription($model);
                $bar->advance();
            }
            $bar->finish();
        }

        $this->newLine(2);
        $this->info('Set tags and covers');
        $bar = $this->output->createProgressBar(count($list));
        $bar->start();
        foreach ($list as $key => $model) {
            /** @var Serie $model */
            SerieConverter::setTags($model);
            if (! $default) {
                SerieConverter::setCover($model);
            }
            $bar->advance();
        }
        $bar->finish();
    }
}
