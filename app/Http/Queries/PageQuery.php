<?php

namespace App\Http\Queries;

use App\Exports\PageExport;
use App\Http\Queries\Addon\QueryOption;
use App\Http\Queries\Filter\GlobalSearchFilter;
use App\Http\Resources\Admin\PageResource;
use App\Models\Page;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PageQuery extends BaseQuery
{
    public function make(?QueryOption $option = null): self
    {
        if (! $option) {
            $option = new QueryOption(resource: PageResource::class);
        }

        $this->option = $option;
        $option->with = [] === $option->with ? [] : $this->option->with;

        $this->query = QueryBuilder::for(Page::class)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['title'])),
                AllowedFilter::exact('id'),
                AllowedFilter::partial('title'),
            ])
            ->allowedSorts(['id', 'title', 'created_at', 'updated_at'])
            ->with($option->with)
            ->orderByDesc($this->option->orderBy)
        ;

        if ($this->option->withExport) {
            $this->export = new PageExport($this->query);
        }
        $this->resource = 'pages';

        return $this;
    }

    public function collection(): AnonymousResourceCollection
    {
        return $this->getCollection();
    }

    public function get(): array
    {
        return [
            'sort' => request()->get('sort', $this->option->defaultSort),
            'filter' => request()->get('filter'),
            'pages' => fn () => $this->collection(),
        ];
    }
}
