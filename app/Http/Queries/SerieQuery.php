<?php

namespace App\Http\Queries;

use App\Exports\SerieExport;
use App\Http\Queries\Addon\QueryOption;
use App\Http\Queries\Filter\GlobalSearchFilter;
use App\Http\Resources\Admin\SerieResource;
use App\Models\Serie;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SerieQuery extends BaseQuery
{
    public function make(?QueryOption $option = null): self
    {
        if (! $option || null === $option->resource) {
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
                AllowedFilter::exact('type'),
                AllowedFilter::scope('types', 'whereTypesIs'),
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
        return $this->getCollection();
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
