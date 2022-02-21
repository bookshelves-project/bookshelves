<?php

namespace App\Http\Queries;

use App\Exports\PostExport;
use App\Http\Queries\Addon\QueryOption;
use App\Http\Queries\Filter\GlobalSearchFilter;
use App\Http\Resources\Admin\PostResource;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PostQuery extends BaseQuery
{
    public function make(?QueryOption $option = null): self
    {
        if (! $option) {
            $option = new QueryOption(resource: PostResource::class);
        }

        $this->option = $option;
        $option->with = [] === $option->with ? ['category', 'media', 'tags', 'user'] : $this->option->with;

        $this->query = QueryBuilder::for(Post::class)
            ->defaultSort($this->option->defaultSort)
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
            ->with($option->with)
        ;

        if ($this->option->withExport) {
            $this->export = new PostExport($this->query);
        }
        $this->resource = 'posts';

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
            'posts' => fn () => $this->collection(),
        ];
    }
}
