<?php

namespace App\Jobs;

use App\Models\Author;
use App\Models\Serie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kiwilan\Steward\Services\Wikipedia\Wikipediable;
use Kiwilan\Steward\Services\WikipediaService;
use Kiwilan\Steward\Utils\MetaClass;

class WikipediaProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
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
     * Request Wikipedia API for each `className`.
     *
     * @param  string  $className        like `Author::class`
     * @param  string[]  $attributes     used to create Wikipedia query, like `['firstname', 'lastname']`
     * @param  string  $languageField field into model which corresponding to Model language, like `language_slug`, default is `language_slug`
     * @return int Number of requests
     */
    private function wikipediaRequest(string $className, array $attributes, string $languageField = 'language_slug'): int
    {
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
