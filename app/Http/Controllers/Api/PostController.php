<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Post\PostCollectionResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @group Blog
 *
 * APIs for Blog.
 */
#[Prefix('posts')]
class PostController extends ApiController
{
    /**
     * GET Post[].
     *
     * Get all Posts ordered by `published_at`.
     *
     * @responseField data Post[] List of posts.
     */
    #[Get('/', name: 'api.posts.index')]
    public function index(Request $request)
    {
        $posts = Post::published()
            ->paginate($request->get('limit') ?? Post::DEFAULT_PER_PAGE)
        ;

        return PostCollectionResource::collection($posts);
    }

    /**
     * GET Post.
     */
    #[Get('/{post_slug}', name: 'api.posts.show')]
    public function show(Post $post)
    {
        return PostResource::make($post);
    }
}
