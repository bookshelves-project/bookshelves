<?php

namespace App\Jobs;

use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\Steward\Services\GoogleBook\GoogleBookable;
use Kiwilan\Steward\Services\GoogleBookService;
use Kiwilan\Steward\Services\Wikipedia\Wikipediable;
use Kiwilan\Steward\Services\WikipediaService;
use Kiwilan\Steward\Utils\MetaClass;

class ExternalApiProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected bool $books = false,
        protected bool $authors = false,
        protected bool $series = false,
        protected bool $verbose = false,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->books) {
            $this->googleBookRequest(Book::class, ['isbn13', 'isbn10']);
        }

        if ($this->authors) {
            $this->wikipediaRequest(
                Author::class,
                ['firstname', 'lastname'],
            );
        }

        if ($this->series) {
            $this->wikipediaRequest(
                Serie::class,
                ['title']
            );
        }
    }

    /**
     * Request Google Book API for each `$subject`.
     *
     * @param  string  $className     Class name, like `Book::class`
     * @param  string[]  $isbnFields Fields into `$subject` with ISBN, set more relevant first, like `['isbn13', 'isbn10']`
     * @return int Number of requests
     */
    private function googleBookRequest(string $className, array $isbnFields): int
    {
        $service = GoogleBookService::make($className::all())
            ->setIsbnFields($isbnFields)
            ->setDebug($this->verbose)
        ;

        $count = $service->getCount();
        $isbn_types = implode('/', $isbnFields);
        // $this->comment("Need to have {$isbn_types}, on {$className::count()} entities, {$count} entities can be scanned.");

        // if (0 === $count) {
        //     $this->warn('No entities to scan.');

        //     return $count;
        // }

        $start = microtime(true); // register time
        $service = $service->execute();

        // $bar = $this->output->createProgressBar(count($service->items()));

        foreach ($service->getItems() as $id => $item) {
            $model = $className::find($id);

            if ($model instanceof GoogleBookable) {
                $model->googleBookConvert($item);
            }
        }

        $time_elapsed_secs = number_format(microtime(true) - $start, 2);
        // $this->info("Time in seconds: {$time_elapsed_secs}"); // display time

        return $count;
    }

    /**
     * Request Wikipedia API for each `className`.
     *
     * @param  string  $className        like `Author::class`
     * @param  string[]  $attributes     used to create Wikipedia query, like `['firstname', 'lastname']`
     * @param  string  $languageField field into model which corresponding to Model language, like `language_slug`, default is `language_slug`
     * @return int Number of requests
     */
    private function wikipediaRequest(
        string $className,
        array $attributes,
        string $languageField = 'language_slug'
    ): int {
        $meta = MetaClass::make($className);

        // $this->comment("{$meta->className()} (--{$meta->classSlugPlural()}|-{$meta->firstChar()} option)");

        // if (! $this->default) {
        //     $this->info('- Picture from relation or Wikipedia (--default|-D to skip)');
        // }
        // $this->info("  - Default picture can be JPG file with slug of {$meta->classSlug()} in `public/storage/data/{$meta->classSlugPlural()}`");
        // $this->info('- Description from Wikipedia (--local|-L to skip)');
        // $this->info("  - Default description can be in `public/storage/data/{$meta->classSlugPlural()}/{$meta->classSlugPlural()}.json`");

        $service = WikipediaService::make($className::all())
            ->setLanguageAttribute($languageField)
            ->setQueryAttributes($attributes)
            ->setDebug($this->verbose)
        ;

        $start = microtime(true);
        $service->execute();

        // $bar = $this->output->createProgressBar(count($service->items()));

        foreach ($service->getItems() as $id => $item) {
            $model = $className::find($id);

            if ($model instanceof Wikipediable) {
                $model->wikipediaConvert($item);
            }
        }

        $time_elapsed_secs = number_format(microtime(true) - $start, 2);

        return $service->getCount();
    }
}
