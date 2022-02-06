<?php

namespace App\Http\Queries;

use App\Exports\StubExport;
use App\Http\Resources\Admin\StubResource;
use App\Models\Stub;
use App\Support\GlobalSearchFilter;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class StubQuery extends BaseQuery
{
    public function make(): self
    {
        $this->query = QueryBuilder::for(Stub::class)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['stubAttr'])),
                AllowedFilter::exact('id'),
                AllowedFilter::partial('stubAttr'),
            ])
            ->allowedSorts(['id', 'stubAttr', 'created_at', 'updated_at'])
            ->orderByDesc('id')
        ;

        $this->export = new StubExport($this->query);
        $this->resource = 'stubs';

        return $this;
    }

    public function collection(): AnonymousResourceCollection
    {
        return StubResource::collection($this->paginate());
    }

    public function get(): array
    {
        return [
            'sort' => request()->get('sort', '-id'),
            'filter' => request()->get('filter'),
            'stubs' => fn () => $this->collection(),
        ];
    }
}
