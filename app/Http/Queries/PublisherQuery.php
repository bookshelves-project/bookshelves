<?php

namespace App\Http\Queries;

use App\Exports\LanguageExport;
use App\Http\Resources\Admin\PublisherResource;
use App\Models\Publisher;
use App\Support\GlobalSearchFilter;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PublisherQuery extends BaseQuery
{
    public function make(): self
    {
        $this->query = QueryBuilder::for(Publisher::class)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['name',  'slug'])),
                AllowedFilter::partial('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('slug'),
            ])
            ->allowedSorts(['id', 'name', 'slug', 'books_count', 'created_at', 'updated_at'])
            ->withCount('books')
            ->orderByDesc('id')
        ;

        $this->export = new LanguageExport($this->query);
        $this->resource = 'languages';

        return $this;
    }

    public function collection(): AnonymousResourceCollection
    {
        return PublisherResource::collection($this->paginate());
    }

    public function get(): array
    {
        return [
            'sort' => request()->get('sort', '-id'),
            'filter' => request()->get('filter'),
            'publishers' => fn () => $this->collection(),
        ];
    }
}
