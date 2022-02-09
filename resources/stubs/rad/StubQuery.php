<?php

namespace App\Http\Queries;

use App\Exports\StubExport;
use App\Http\Queries\Addon\QueryOption;
use App\Http\Resources\Admin\StubResource;
use App\Models\Stub;
use App\Support\GlobalSearchFilter;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class StubQuery extends BaseQuery
{
    public function make(?QueryOption $option = null): self
    {
        if (! $option) {
            $option = new QueryOption();
            $option->resource = StubResource::class;
            $option->with = [];
        }

        $this->option = $option;

        $this->query = QueryBuilder::for(Stub::class)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['stubAttr'])),
                AllowedFilter::exact('id'),
                AllowedFilter::partial('stubAttr'),
            ])
            ->allowedSorts(['id', 'stubAttr', 'created_at', 'updated_at'])
            ->with($option->with)
            ->withCount()
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
        /** @var JsonResource $resource */
        $resource = $this->option->resource;

        return $resource::collection($this->paginate());
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
