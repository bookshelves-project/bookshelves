<?php

namespace App\Http\Queries;

use App\Exports\AuthorExport;
use App\Http\Queries\Addon\QueryOption;
use App\Http\Resources\Admin\AuthorResource;
use App\Models\Author;
use App\Support\GlobalSearchFilter;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AuthorQuery extends BaseQuery
{
    public function make(?QueryOption $option = null): self
    {
        if (! $option) {
            $option = new QueryOption();
            $option->resource = AuthorResource::class;
            $option->with = ['series', 'books', 'media'];
        }

        $this->option = $option;

        $this->query = QueryBuilder::for(Author::class)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['firstname', 'lastname', 'name'])),
                AllowedFilter::partial('firstname'),
                AllowedFilter::partial('lastname'),
            ])
            ->allowedSorts(['id', 'firstname', 'lastname', 'name', 'books_count', 'series_count', 'created_at', 'updated_at'])
            ->with($option->with)
            ->withCount('series', 'books')
            ->orderByDesc($this->option->orderBy)
        ;

        if ($this->option->withExport) {
            $this->export = new AuthorExport($this->query);
        }
        $this->resource = 'authors';

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
            'authors' => fn () => $this->collection(),
        ];
    }
}
