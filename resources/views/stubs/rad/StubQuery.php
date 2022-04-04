<?php

namespace App\Http\Queries;

use App\Exports\StubExport;
use App\Http\Queries\Addon\QueryOption;
use App\Http\Queries\Filter\GlobalSearchFilter;
use App\Http\Resources\Admin\StubResource;
use App\Models\Stub;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class StubQuery extends BaseQuery
{
    public function make(?QueryOption $option = null): self
    {
        if (! $option) {
            $option = new QueryOption(resource: StubResource::class);
        }

        $this->option = $option;
        $option->with = [] === $option->with ? [] : $this->option->with;

        $this->query = QueryBuilder::for(Stub::class)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['stubAttr'])),
                AllowedFilter::exact('id'),
                AllowedFilter::partial('stubAttr'),
            ])
            ->allowedSorts(['id', 'stubAttr', 'created_at', 'updated_at'])
            ->with($option->with)
            ->orderByDesc($this->option->orderBy)
        ;

        if ($this->option->withExport) {
            $this->export = new StubExport($this->query);
        }
        $this->resource = 'stubsKebab';

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
            'stubsKebab' => fn () => $this->collection(),
        ];
    }
}
