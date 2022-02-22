<?php

namespace App\Http\Queries;

use App\Exports\WikipediaItemExport;
use App\Http\Queries\Addon\QueryOption;
use App\Http\Queries\Filter\GlobalSearchFilter;
use App\Http\Resources\Admin\WikipediaItemResource;
use App\Models\WikipediaItem;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class WikipediaItemQuery extends BaseQuery
{
    public function make(?QueryOption $option = null): self
    {
        if (! $option) {
            $option = new QueryOption(resource: WikipediaItemResource::class);
        }

        $this->option = $option;
        $option->with = [] === $option->with ? ['author', 'serie'] : $this->option->with;

        $this->query = QueryBuilder::for(WikipediaItem::class)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['search_query'])),
                AllowedFilter::exact('id'),
                AllowedFilter::partial('search_query'),
            ])
            ->allowedSorts(['id', 'search_query', 'created_at', 'updated_at'])
            ->with($option->with)
            ->orderByDesc($this->option->orderBy)
        ;

        if ($this->option->withExport) {
            $this->export = new WikipediaItemExport($this->query);
        }
        $this->resource = 'wikipedia-items';

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
            'wikipedia-items' => fn () => $this->collection(),
        ];
    }
}
