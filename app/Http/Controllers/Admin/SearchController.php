<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PostResource;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;

class SearchController extends Controller
{
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
