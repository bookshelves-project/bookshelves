<?php

namespace App\Console\Commands\Bookshelves;

use App\Console\CommandProd;
use App\Engines\ConverterEngine\EntityConverter;
use App\Enums\MediaDiskEnum;
use App\Models\Author;
use App\Models\Book;
use App\Models\GoogleBook;
use App\Models\Serie;
use App\Models\WikipediaItem;
use App\Services\DirectoryClearService;
use App\Services\GoogleBookService;
use App\Services\WikipediaService;
use ReflectionClass;

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

        DirectoryClearService::create([storage_path('app/public/debug/wikipedia')]);

        $authors = $this->option('authors') ?? false;
        $series = $this->option('series') ?? false;
        $books = $this->option('books') ?? false;

        if ($books) {
            $this->googleBook();
        }
        if ($authors) {
            $this->wikipediaRequest(new Author(), 'lastname', ['firstname', 'lastname'], 'language_slug');
        }
        if ($series) {
            $this->wikipediaRequest(new Serie(), 'slug_sort', ['title']);
        }

        return true;
    }

    private function googleBook()
    {
        $this->comment('Books (REMOVE --books|-b to skip)');
        $this->info('- GoogleBook: extract data to improve Book');
        $this->newLine();

        $fresh = $this->option('fresh') ?? false;
        $debug = $this->option('debug') ?? false;

        if ($fresh) {
            GoogleBook::query()->delete();
        }

        $count = Book::whereNotNull('isbn10')
            ->orWhereNotNull('isbn13')
            ->count()
        ;
        $this->comment("Need to have ISBN, {$count} books can be scanned");
        $start = microtime(true);
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

        $this->newLine();
        $this->newLine();
        $time_elapsed_secs = number_format(microtime(true) - $start, 2);
        $this->info("Time in seconds: {$time_elapsed_secs}");
        $this->newLine();

        return true;
    }

    private function wikipediaRequest(Author|Serie $model_name, string $orderBy, array $attribute, string $language_attribute = 'language_slug')
    {
        $debug = $this->option('debug') ?? false;
        $default = $this->option('default') ?? false;
        $fresh = $this->option('fresh') ?? false;

        $class = new ReflectionClass($model_name);
        $class = $class->getShortName();

        if ('Serie' === $class) {
            $this->comment('Series (REMOVE --series|-s to skip)');
            $this->info('- Tags from all Books of Serie');
            if (! $default) {
                $this->info('- Picture from first Book of Serie (--default|-D to skip)');
            }
            $this->info('  - Default picture can be JPG file with slug of serie in `public/storage/data/series`');
            $this->info('- Description from Wikipedia (--local|-L to skip)');
            $this->info('  - Default description can be in `public/storage/data/series/series.json`');
            $this->newLine();
        }

        if ('Author' === $class) {
            $this->comment('Authors (REMOVE --authors|-a to skip)');
            $this->info('- Picture from Wikipedia');
            if (! $default) {
                $this->info('  - Default picture can be JPG file with slug of serie in `public/storage/data/authors` (--default|-D to skip)');
            }
            $this->info('- Description from Wikipedia (--local|-L to skip)');
            $this->info('  - Default description can be in `public/storage/data/authors/authors.json`');
            $this->newLine();
        }

        $list = $model_name::orderBy($orderBy)->get();
        $this->comment($class.': '.count($list));

        $start = microtime(true);

        if ($fresh) {
            $class_name = new ReflectionClass($model_name);
            WikipediaItem::whereModel($class_name->getName())->delete();
            /** @var Author|Serie $model */
            foreach ($list as $model) {
                // $model->clearMediaCollection(MediaDiskEnum::cover->value);
                $model->description = null;
                $model->link = null;
                $model->save();
            }
        }

        $service = WikipediaService::create($model_name, $attribute, $language_attribute, $debug);
        $this->newLine();

        $bar = $this->output->createProgressBar(count($service->queries));
        $bar->start();
        foreach ($model_name::has('wikipedia')->get() as $entity) {
            /** @var Author|Serie $entity */
            EntityConverter::setWikipediaDescription($entity);
            if (! $default && $entity instanceof Author) {
                EntityConverter::setWikipediaCover($entity);
            }
            $bar->advance();
        }
        $bar->finish();

        $this->newLine();
        $this->newLine();
        $time_elapsed_secs = number_format(microtime(true) - $start, 2);
        $this->info("Time in seconds: {$time_elapsed_secs}");

        $this->newLine();
    }
}
