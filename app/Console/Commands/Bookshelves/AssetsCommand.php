<?php

namespace App\Console\Commands\Bookshelves;

use App\Models\Serie;
use App\Models\Author;
use Illuminate\Console\Command;
use App\Providers\WikipediaProvider;
use App\Providers\GoogleBookProvider;
use Illuminate\Database\Eloquent\Model;
use App\Providers\BookshelvesConverterEngine\SerieConverter;
use App\Providers\BookshelvesConverterEngine\AuthorConverter;

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
    protected $description = 'Generate assets for Authors and Series with Wikipedia';

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
        $authors = $this->option('authors') ?? false;
        $series = $this->option('series') ?? false;
        $books = $this->option('books') ?? false;

        $app = config('app.name');
        $this->newLine();
        $this->alert("$app: assets");
        $this->comment('Get assets from API: HTTP requests (--local|-L to skip)');
        $this->newLine();
        if ($books) {
            $this->comment('Books (REMOVE --books|-b to skip)');
            $this->info("- GoogleBook: extract data to improve Book (--local|-L to skip)");
            $this->newLine();
        }
        if ($authors) {
            $this->comment('Authors (REMOVE --authors|-a to skip)');
            $this->info('- Picture from Wikipedia (--local|-L to skip)');
            $this->info("  - Custom: default can be JPG file with slug of serie in `public/storage/data/pictures-authors` (--default|-D to skip)");
            $this->info('- Description from Wikipedia (--local|-L to skip)');
            $this->info("  - Custom: default can be in `public/storage/data/authors.json`");
            $this->newLine();
        }
        if ($series) {
            $this->comment('Series (REMOVE --series|-s to skip)');
            $this->info('- Tags from all Books of Serie');
            $this->info('- Picture from first Book of Serie (--default|-D to skip)');
            $this->info("  - Custom: default can be JPG file with slug of serie in `public/storage/data/pictures-series`");
            $this->info('- Description from Wikipedia (--local|-L to skip)');
            $this->info("  - Custom: default can be in `public/storage/data/series.json`");
            $this->newLine();
        }

        if ($books) {
            $this->assets('Book', 'books', 'title_sort');
        }
        if ($authors) {
            $this->assets('Author', 'authors', 'lastname');
        }
        if ($series) {
            $this->assets('Serie', 'series', 'title_sort');
        }
        
        return 0;
    }

    private function assets(string $model, string $collection, string $orderBy)
    {
        $model_name = 'App\Models\\' . ucfirst($model);
        $this->comment($model);
        $this->newLine();
        $list = $model_name::orderBy($orderBy)->get();

        $bar = $this->output->createProgressBar(count($list));
        $bar->start();
        foreach ($list as $key => $entity) {
            $this->$collection($entity, $collection);
            $bar->advance();
        }
        $bar->finish();
        $this->newLine(2);
    }

    private function books(Model $entity, string $collection)
    {
        $local = $this->option('local') ?? false;
        if (! $local) {
            $gbook = GoogleBookProvider::create($entity);
            $gbook->convert()->improveBookData();
        }
    }
    
    private function authors(Model $model, string $collection)
    {
        $fresh = $this->option('fresh') ?? false;
        $local = $this->option('local') ?? false;
        $default = $this->option('default') ?? false;
        
        if ($fresh) {
            $model->clearMediaCollection($collection);
            $model->description = null;
            $model->link = null;
            $model->save();
        }

        /** @var Author $model */
        if (! $model->description && ! $model->link) {
            // http request to wikipedia if not $local
            if (! $local) {
                $wiki = WikipediaProvider::create($model->name);

                AuthorConverter::setWikiDescription($model, $wiki);
                // if not $default, add picture
                if (! $default) {
                    AuthorConverter::setWikiPicture($model, $wiki);
                    // set local picture over wiki
                    AuthorConverter::setLocalPicture($model);
                }
            } else {
                // set local if exist
                AuthorConverter::setLocalPicture($model);
            }
        }
    }
    
    private function series(Model $model, string $collection)
    {
        $fresh = $this->option('fresh') ?? false;
        $local = $this->option('local') ?? false;
        $default = $this->option('default') ?? false;
        
        if ($fresh) {
            $model->clearMediaCollection($collection);
            $model->description = null;
            $model->link = null;
            $model->save();
        }
        
        /** @var Serie $model */
        if (! $model->description && ! $model->link) {
            SerieConverter::setTags($model);
            if (! $default) {
                SerieConverter::setCover($model);
            }
            if (! $local) {
                $wiki = WikipediaProvider::create($model->title, $model->language_slug);

                SerieConverter::setWikiDescription($model, $wiki);
            }
        }
    }
}
