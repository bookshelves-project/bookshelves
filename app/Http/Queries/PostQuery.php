<?php

namespace App\Http\Queries;

use App\Http\Queries\Base\BaseQuery;
use App\Http\Queries\Base\QueryOption;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PostQuery extends BaseQuery
{
    public static function make(?QueryOption $option = null): PostQuery
    {
        /** @var PostQuery */
        $instance = BaseQuery::setup(Post::class, PostResource::class, $option, [
            'tags',
            'author',
            'authorSecondary',
        ]);

        $instance->query = QueryBuilder::for(Post::class)
            ->defaultSort($instance->option->orderBy)
            ->allowedFilters([
                AllowedFilter::partial('title'),
                'published_at',
                'type',
            ])
            ->allowedSorts([
                'id',
                'title',
                'published_at',
            ])
            ->allowedIncludes('tags', 'author', 'authorSecondary')
            ->with($instance->option->with)
        ;

        return $instance;
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
            $this->resource => fn () => $this->collection(),
        ];
    }
}
