<?php

namespace App\Jobs;

use App\Engines\Book\Converter\EntityConverter;
use App\Engines\Book\Converter\Modules\CoverConverter;
use App\Models\Author;
use App\Models\Serie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BookRelationsParserProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected bool $default = false,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->parseRelation(Author::class);
        $this->parseRelation(Serie::class);
    }

    private function parseRelation(string $model)
    {
        Log::info("BookRelationsParserProcess: {$model}");

        /** @var Serie|Author $entity */
        foreach ($model::all() as $entity) {
            Log::info("BookRelationsParserProcess: {$model} {$entity->id}");
            EntityConverter::make($entity)
                ->setTags()
                ->parseLocalData();

            if (! $this->default) {
                CoverConverter::setLocalCover($entity);
            }
        }
    }
}
