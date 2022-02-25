<?php

namespace App\Http\Queries;

use App\Models\Serie;
use App\Exports\SerieExport;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Queries\Addon\QueryOption;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\Admin\SerieResource;
use App\Http\Queries\Filter\GlobalSearchFilter;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SerieQuery extends BaseQuery
{
    public function make(?QueryOption $option = null): self
    {
        if (! $option) {
            $option = new QueryOption(resource: SerieResource::class);
        }

        $this->option = $option;
        $option->with = [] === $option->with ? ['books', 'media', 'authors', 'language', 'tags'] : $this->option->with;

        $this->query = QueryBuilder::for(Serie::class)
            ->defaultSort($this->option->defaultSort)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['title'])),
                AllowedFilter::partial('title'),
                AllowedFilter::partial('authors'),
                AllowedFilter::callback('language', function (Builder $query, $value) {
                    return $query->whereHas('language', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                }),
                AllowedFilter::scope('languages', 'whereLanguagesIs'),
                AllowedFilter::scope('language', 'whereLanguagesIs'),
            ])
            ->allowedSorts(['id', 'title', 'authors', 'books_count', 'language', 'created_at', 'updated_at', 'language'])
            ->with($option->with)
            ->withCount('books', 'tags')
        ;

        if ($this->option->withExport) {
            $this->export = new SerieExport($this->query);
        }
        $this->resource = 'series';

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
            'series' => fn () => $this->collection(),
        ];
    }
}
