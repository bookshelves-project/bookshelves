<?php

namespace App\Jobs;

use App\Models\Author;
use App\Models\Serie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Kiwilan\HttpPool\Utils\PrintConsole;
use Kiwilan\Steward\Services\ClassParser\MetaClassItem;
use Kiwilan\Steward\Services\Wikipedia\Wikipediable;
use Kiwilan\Steward\Services\WikipediaService;

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
        Log::info('WikipediaProcess');

        if ($this->authors) {
            $this->wikipediaRequest(
                Author::class,
                ['firstname', 'lastname'],
                ['author', 'auteur']
            );
        }

        if ($this->series) {
            $this->wikipediaRequest(
                Serie::class,
                ['title'],
                ['series', 'série']
            );
        }
    }

    /**
     * Request Wikipedia API for each `className`.
     *
     * @param  string  $className        like `Author::class`
     * @param  string[]  $attributes     used to create Wikipedia query, like `['firstname', 'lastname']`
     * @return int Number of requests
     */
    private function wikipediaRequest(string $className, array $attributes, ?array $precision = null): int
    {
        Log::info("WikipediaProcess: {$className}");

        $meta = MetaClassItem::make($className);
        $console = PrintConsole::make();

        $console->print("{$meta->getClassName()} (--{$meta->getClassSlugPlural()}|-{$meta->getFirstChar()} option)");

        // if (! $this->default) {
        //     $console->print('- Picture from relation or Wikipedia (--default|-D to skip)');
        // }
        // $console->print("  - Default picture can be JPG file with slug of {$meta->classSlug()} in `public/storage/data/{$meta->classSlugPlural()}`");
        // $console->print('- Description from Wikipedia (--local|-L to skip)');
        // $console->print("  - Default description can be in `public/storage/data/{$meta->classSlugPlural()}/{$meta->classSlugPlural()}.json`");

        $service = WikipediaService::make($className::all())
            ->setLanguageAttribute('language_slug')
            ->setQueryAttributes($attributes)
            ->setDebug($this->verbose);

        if ($precision) {
            $service->setPrecisionQuery($precision);
        }

        $start = microtime(true);
        $service->execute();

        // $bar = $this->output->createProgressBar(count($service->items()));

        foreach ($service->getItems() as $id => $item) {
            Log::info("WikipediaProcess: {$id}");
            $model = $className::find($id);

            if ($model instanceof Wikipediable) {
                $model->wikipediaConvert($item);
            }
        }

        $time_elapsed_secs = number_format(microtime(true) - $start, 2);
        $console->print("Time in seconds: {$time_elapsed_secs}");

        return $service->getCount();
    }
}
