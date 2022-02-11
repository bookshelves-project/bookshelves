<?php

namespace App\Http\Queries;

use App\Exports\LanguageExport;
use App\Http\Queries\Addon\QueryOption;
use App\Http\Resources\Admin\PublisherResource;
use App\Models\Publisher;
use App\Support\GlobalSearchFilter;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PublisherQuery extends BaseQuery
{
    public function make(?QueryOption $option = null): self
    {
        if (! $option) {
            $option = new QueryOption();
            $option->resource = PublisherResource::class;
        }

        $this->option = $option;
        $option->with = [] === $option->with ? [] : $this->option->with;

        $this->query = QueryBuilder::for(Publisher::class)
            ->defaultSort($this->option->defaultSort)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['name',  'slug'])),
                AllowedFilter::partial('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('slug'),
            ])
            ->allowedSorts(['id', 'name', 'slug', 'books_count', 'created_at', 'updated_at'])
            ->with($option->with)
            ->withCount('books')
        ;

        if ($this->option->withExport) {
            $this->export = new LanguageExport($this->query);
        }
        $this->resource = 'languages';

        return $this;
    }

    public function collection(): AnonymousResourceCollection
    {
        /** @var JsonResource $resource */
        $resource = $this->option->resource;

        return $resource::collection($this->paginate());
    }

    public function get(): array
    {
        return [
            'sort' => request()->get('sort', $this->option->defaultSort),
            'filter' => request()->get('filter'),
            'publishers' => fn () => $this->collection(),
        ];
    }
}