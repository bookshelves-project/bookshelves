<?php

namespace App\Http\Queries;

use App\Exports\BookExport;
use App\Http\Queries\Addon\QueryOption;
use App\Models\Book;
use App\Support\GlobalSearchFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BookQuery extends BaseQuery
{
    public function make(?QueryOption $option = null)
    {
        $this->option = $option;

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
                AllowedFilter::callback('publisher', function (Builder $query, $value) {
                    return $query->whereHas('publisher', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                }),
            ])
            ->allowedSorts(['id', 'title', 'title_sort', 'type', 'serie', 'authors', 'volume', 'publisher',  'released_on', 'created_at', 'updated_at'])
            ->with('serie', 'media', 'authors', 'language', 'publisher')
            ->withCount('tags')
            ->defaultSort($option->defaultSort)
            ->defaultSort('id')
        ;

        if ($this->option->withExport) {
            $this->export = new BookExport($this->query);
        }
        $this->resource = 'books';

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
            // 'sort' => request()->get('sort', $this->option->defaultSort),
            'sort' => request()->get('sort', '-id'),
            'filter' => request()->get('filter'),
            'books' => fn () => $this->collection(),
        ];
    }
}
