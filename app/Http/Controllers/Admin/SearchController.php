<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AuthorResource;
use App\Http\Resources\Admin\BookResource;
use App\Http\Resources\Admin\PostResource;
use App\Http\Resources\Admin\SerieResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Post;
use App\Models\Serie;
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
