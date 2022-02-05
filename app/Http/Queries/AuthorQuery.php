<?php

namespace App\Http\Queries;

use App\Exports\AuthorExport;
use App\Http\Resources\Admin\AuthorResource;
use App\Models\Author;
use App\Support\GlobalSearchFilter;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AuthorQuery extends BaseQuery
{
    public function make(): self
    {
        $this->query = QueryBuilder::for(Author::class)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['firstname', 'lastname', 'name'])),
                AllowedFilter::partial('firstname'),
                AllowedFilter::partial('lastname'),
            ])
            ->allowedSorts(['id', 'firstname', 'lastname', 'name', 'books_count', 'series_count', 'created_at', 'updated_at'])
            ->with('series', 'books', 'media')
            ->withCount('series', 'books')
            ->orderByDesc('id')
        ;

        $this->export = new AuthorExport($this->query);
        $this->resource = 'authors';

        return $this;
    }

    public function collection(): AnonymousResourceCollection
    {
        return AuthorResource::collection($this->paginate());
    }

    public function get(): array
    {
        return [
            'sort' => request()->get('sort', '-id'),
            'filter' => request()->get('filter'),
            'authors' => fn () => $this->collection(),
        ];
    }
}
