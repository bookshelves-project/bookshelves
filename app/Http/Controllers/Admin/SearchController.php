<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\Post;
use Inertia\Inertia;
use App\Models\Serie;
use App\Models\Author;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\Admin\BookResource;
use App\Http\Resources\Admin\PostResource;
use Spatie\RouteAttributes\Attributes\Get;
use App\Http\Resources\Admin\SerieResource;
use App\Http\Resources\Admin\AuthorResource;

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
            'books' => BookResource::collection(Book::search($query)->query(function (Builder $builder) {
                $builder->with('serie', 'authors');
            })->get()),
            'series' => SerieResource::collection(Serie::search($query)->query(function (Builder $builder) {
                $builder->with('authors');
            })->get()),
            'authors' => AuthorResource::collection(Author::search($query)->query(function (Builder $builder) {
                $builder->with('books');
            })->get()),
        ]);
    }
}
