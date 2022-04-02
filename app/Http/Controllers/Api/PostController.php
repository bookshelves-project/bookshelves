<?php

namespace App\Http\Controllers\Api;

use App\Http\Queries\Addon\QueryOption;
use App\Http\Queries\PostQuery;
use App\Http\Resources\Api\Post\PostCollectionResource;
use App\Http\Resources\Api\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @group Relation: Post
 *
 * Endpoint to get Posts data.
 */
#[Prefix('posts')]
class PostController extends ApiController
{
    /**
     * GET Post[].
     */
    #[Get('/', name: 'posts.index')]
    public function index(Request $request)
    {
        $this->getLang($request);

        return app(PostQuery::class)
            ->make(QueryOption::create(
                request: $request,
                resource: PostCollectionResource::class,
                orderBy: 'published_at',
                withExport: false,
                sortAsc: true,
                full: $this->getFull($request),
            ))
            ->paginateOrExport()
        ;
    }

    /**
     * GET Post.
     */
    #[Get('/{post_slug}', name: 'posts.show')]
    public function show(Request $request, Post $post)
    {
        $this->getLang($request);

        return PostResource::make($post);
    }
}
