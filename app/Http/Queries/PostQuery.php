<?php

namespace App\Http\Queries;

use App\Exports\PostExport;
use App\Http\Resources\Admin\PostResource;
use App\Models\Post;
use App\Support\GlobalSearchFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PostQuery extends BaseQuery
{
    public function make(): self
    {
        $this->query = QueryBuilder::for(Post::class)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['title', 'summary', 'body'])),
                AllowedFilter::partial('title'),
                AllowedFilter::partial('summary'),
                AllowedFilter::partial('body'),
                AllowedFilter::exact('id'),
                AllowedFilter::exact('category', 'category_id'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('pin'),
                AllowedFilter::exact('promote'),
                AllowedFilter::scope('published_at', 'publishedBetween'),
                AllowedFilter::callback('user', function (Builder $query, $value) {
                    return $query->whereHas('user', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                }),
            ])
            ->allowedSorts(['id', 'title', 'published_at', 'created_at', 'updated_at'])
            ->with('category', 'media', 'tags', 'user')
            ->orderByDesc('id')
        ;

        $this->export = new PostExport($this->query);
        $this->resource = 'posts';

        return $this;
    }

    public function collection(): AnonymousResourceCollection
    {
        return PostResource::collection($this->paginate());
    }

    public function get(): array
    {
        return [
            'sort' => request()->get('sort', '-id'),
            'filter' => request()->get('filter'),
            'posts' => fn () => $this->collection(),
        ];
    }
}
