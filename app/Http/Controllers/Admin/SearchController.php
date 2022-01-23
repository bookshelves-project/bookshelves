<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PostResource;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Get;

class SearchController extends Controller
{
    #[Get('search/{query?}', name: 'search')]
    public function index(string $query = '')
    {
        Inertia::share(['query' => $query]);

        return Inertia::render('Search', [
            'query' => $query,
            'posts' => PostResource::collection(Post::search($query)->query(function (Builder $builder) {
                $builder->with('media');
            })->get()),
        ]);
    }
}
