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
                AllowedFilter::custom('q', new GlobalSearchFilter(['title'])),
                AllowedFilter::partial('title'),
                AllowedFilter::partial('serie'),
                AllowedFilter::partial('volume'),
                AllowedFilter::partial('authors'),
                AllowedFilter::exact('disabled'),
                AllowedFilter::exact('released_on'),
                // AllowedFilter::exact('id'),
                // AllowedFilter::exact('category', 'category_id'),
                // AllowedFilter::exact('status'),
                // AllowedFilter::exact('pin'),
                // AllowedFilter::exact('promote'),
                // AllowedFilter::scope('published_at', 'publishedBetween'),
                // AllowedFilter::callback('user', function (Builder $query, $value) {
                //     return $query->whereHas('user', function (Builder $query) use ($value) {
                //         $query->where('name', 'like', "%{$value}%");
                //     });
                // }),
            ])
            ->allowedSorts(['id', 'title', 'serie', 'authors', 'volume', 'released_on', 'created_at', 'updated_at'])
            // ->with('category', 'media', 'tags', 'user')
            ->with('serie', 'media', 'authors', 'language')
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
