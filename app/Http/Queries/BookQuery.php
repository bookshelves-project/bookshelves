<?php

namespace App\Http\Queries;

use App\Exports\BookExport;
use App\Http\Resources\Admin\BookResource;
use App\Models\Book;
use App\Support\GlobalSearchFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BookQuery extends BaseQuery
{
    public function make(): self
    {
        $this->query = QueryBuilder::for(Book::class)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['title', 'serie'])),
                AllowedFilter::exact('id'),
                AllowedFilter::partial('title'),
                AllowedFilter::callback('serie', function (Builder $query, $value) {
                    return $query->whereHas('serie', function (Builder $query) use ($value) {
                        $query->where('title', 'like', "%{$value}%");
                    });
                }),
                AllowedFilter::partial('volume'),
                AllowedFilter::callback('authors', function (Builder $query, $value) {
                    return $query->whereHas('authors', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                }),
                AllowedFilter::exact('disabled'),
                AllowedFilter::exact('released_on'),
                AllowedFilter::exact('type'),
                AllowedFilter::callback('language', function (Builder $query, $value) {
                    return $query->whereHas('language', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                }),
            ])
            ->allowedSorts(['id', 'title', 'type', 'serie', 'authors', 'volume', 'released_on', 'created_at', 'updated_at'])
            ->with('serie', 'media', 'authors', 'language')
            ->withCount('tags')
            ->orderByDesc('id')
        ;

        $this->export = new BookExport($this->query);
        $this->resource = 'books';

        return $this;
    }

    public function collection(): AnonymousResourceCollection
    {
        return BookResource::collection($this->paginate());
    }

    public function get(): array
    {
        return [
            'sort' => request()->get('sort', '-id'),
            'filter' => request()->get('filter'),
            'books' => fn () => $this->collection(),
        ];
    }
}
