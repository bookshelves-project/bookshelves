<?php

namespace App\Http\Queries;

use App\Models\TagExtend;
use App\Exports\TagExport;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Queries\Addon\QueryOption;
use App\Http\Resources\Admin\TagResource;
use App\Http\Queries\Filter\GlobalSearchFilter;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagQuery extends BaseQuery
{
    public function make(?QueryOption $option = null): self
    {
        if (! $option) {
            $option = new QueryOption(resource: TagResource::class);
        }

        $this->option = $option;
        $option->with = [] === $option->with ? ['books', 'series'] : $this->option->with;

        $this->query = QueryBuilder::for(TagExtend::class)
            ->defaultSort($this->option->defaultSort)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['name',  'slug', 'type'])),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('type'),
                AllowedFilter::partial('books_count'),
                AllowedFilter::partial('series_count'),
                AllowedFilter::partial('first_char'),
                AllowedFilter::scope('show_negligible', 'whereShowNegligible')->default(false),
                AllowedFilter::scope('type', 'whereTypeIs'),
            ])
            ->allowedSorts(['id', 'name', 'slug', 'type', 'first_char', 'books_count', 'series_count', 'created_at', 'updated_at'])
            ->with($option->with)
            ->withCount('books', 'series')
        ;

        if ($this->option->withExport) {
            $this->export = new TagExport($this->query);
        }
        $this->resource = 'tags';

        return $this;
    }

    public function collection(): AnonymousResourceCollection
    {
        /** @var JsonResource $resource */
        $resource = $this->option->resource;
        $response = $this->option->withPagination ? $this->paginate() : $this->query->get();

        return $resource::collection($response);
    }

    public function get(): array
    {
        return [
            'sort' => request()->get('sort', $this->option->defaultSort),
            'filter' => request()->get('filter'),
            'tags' => fn () => $this->collection(),
        ];
    }
}
