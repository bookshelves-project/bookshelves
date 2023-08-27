<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Kiwilan\Steward\Queries\HttpQuery;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('posts')]
class PostController extends Controller
{
    #[Get('/', name: 'posts.index')]
    public function index(Request $request)
    {
        return HttpQuery::for(Post::class, $request)
            ->collection()
        ;
    }

    #[Get('/{post_slug}', name: 'posts.show')]
    public function show(Request $request, Post $post)
    {
        return PostResource::make($post);
    }
}
