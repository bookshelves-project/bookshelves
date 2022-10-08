<?php

namespace App\Console\Commands\Bookshelves;

use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Kiwilan\Steward\Class\MetaClass;
use Kiwilan\Steward\Console\CommandProd;
use Kiwilan\Steward\Services\DirectoryClearService;
use Kiwilan\Steward\Services\GoogleBookService;
use Kiwilan\Steward\Services\GoogleBookService\GoogleBookable;
use Kiwilan\Steward\Services\WikipediaService;
use Kiwilan\Steward\Services\WikipediaService\Wikipediable;

/**
 * Extra data for Book, Author, Serie.
 */
class ApiCommand extends CommandProd
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
                            {--d|debug : print log for debug}
                            {--D|default : use default cover for all (skip covers step)}
                            {--F|force : skip confirm in prod}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate data for Books, Authors, Series from public API.';

    protected bool $fresh = false;
    protected bool $debug = false;
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
     * @return bool
     */
    public function handle()
    {
        $this->intro();

        $this->checkProd();

        DirectoryClearService::make([storage_path('app/public/debug/wikipedia')]);

        $authors = $this->option('authors') ?? false;
        $series = $this->option('series') ?? false;
        $books = $this->option('books') ?? false;

        $this->fresh = $this->option('fresh') ?? false;
        $this->debug = $this->option('debug') ?? false;
        $this->default = $this->option('default') ?? false;

        if ($this->debug) {
            $this->newLine();
            $this->info('Debug mode');
            $this->info('All requests will be printed as JSON into `public/storage/debug/wikipedia` directory.');
            $this->newLine();
        }

        if ($books) {
            $this->googleBookRequest(Book::class, ['isbn13', 'isbn10']);
        }
        if ($authors) {
            $this->wikipediaRequest(
                Author::class,
                ['firstname', 'lastname'],
            );
        }
        if ($series) {
            $this->wikipediaRequest(
                Serie::class,
                ['title']
            );
        }
        return true;
    }

    /**
     * Request Google Book API for each `$subject`.
     *
     * @param string   $subject     Class name, like `Book::class`
     * @param string[] $isbn_fields Fields into `$subject` with ISBN, set more relevant first, like `['isbn13', 'isbn10']`
     *
     * @return int Number of requests
     */
    private function googleBookRequest(string $subject, array $isbn_fields): int
    {
        $models = GoogleBookService::availableModels($subject, $isbn_fields);

        $count = $models->count();
        $isbn_types = implode('/', $isbn_fields);
        $this->comment("Need to have {$isbn_types}, on {$subject::count()} entities, {$count} entities can be scanned.");
        if (0 === $count) {
            $this->warn('No entities to scan.');

            return $count;
        }

        $start = microtime(true); // register time
        $service = GoogleBookService::make(Book::class, $this->debug)
            ->setModels($models)
            ->setIsbnFields($isbn_fields)
            ->execute()
        ;

        $bar = $this->output->createProgressBar(count($service->googleBooks));
        $bar->start();
        foreach ($service->googleBooks as $googleBook) {
            /** @var GoogleBookable */
            $model = $googleBook->model_name::find($googleBook->model_id);
            $model->googleBookConvert($googleBook);
            $bar->advance();
        }
        $bar->finish();

        $this->newLine(2);
        $time_elapsed_secs = number_format(microtime(true) - $start, 2);
        $this->info("Time in seconds: {$time_elapsed_secs}"); // display time
        $this->newLine();

        return $count;
    }

    /**
     * Request Wikipedia API for each `$subject`.
     *
     * @param string   $subject        like `Author::class`
     * @param string[] $attributes     used to create Wikipedia query, like `['firstname', 'lastname']`
     * @param string   $language_field field into model which corresponding to Model language, like `language_slug`, default is `language_slug`
     *
     * @return int Number of requests
     */
    private function wikipediaRequest(
        string $subject,
        array $attributes,
        string $language_field = 'language_slug'
    ): int {
        $meta = MetaClass::make($subject);

        $this->comment("{$meta->class_name} (--{$meta->class_kebab_plural}|-{$meta->first_char} option)");
        if (! $this->default) {
            $this->info('- Picture from relation or Wikipedia (--default|-D to skip)');
        }
        $this->info("  - Default picture can be JPG file with slug of {$meta->class_kebab} in `public/storage/data/{$meta->class_kebab_plural}`");
        $this->info('- Description from Wikipedia (--local|-L to skip)');
        $this->info("  - Default description can be in `public/storage/data/{$meta->class_kebab_plural}/{$meta->class_kebab_plural}.json`");
        $this->newLine();

        $list = $subject::all();
        $this->comment($meta->class_name.': '.count($list));

        $start = microtime(true);

        $service = WikipediaService::make($subject, $this->debug)
            ->setQueryAttributes($attributes)
            ->setLanguageField($language_field)
            ->execute()
        ;
        $this->newLine();

        $bar = $this->output->createProgressBar(count($service->wikipediaItems));
        $bar->start();
        foreach ($service->wikipediaItems as $wikipediaItem) {
            /** @var Wikipediable */
            $model = $wikipediaItem->model_name::find($wikipediaItem->model_id);
            $model->wikipediaConvert($wikipediaItem, $this->default);
            $bar->advance();
        }
        $bar->finish();

        $this->newLine(2);
        $time_elapsed_secs = number_format(microtime(true) - $start, 2);
        $this->info("Time in seconds: {$time_elapsed_secs}");

        $this->newLine();

        return count($list);
    }
}
