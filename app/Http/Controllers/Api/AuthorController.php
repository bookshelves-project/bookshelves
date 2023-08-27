<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Book\BookCollection;
use App\Http\Resources\Serie\SerieCollection;
use App\Models\Author;
use Illuminate\Http\Request;
use Kiwilan\Steward\Queries\HttpQuery;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('authors')]
class AuthorController extends Controller
{
    #[Get('/', name: 'authors.index')]
    public function index(Request $request)
    {
        return HttpQuery::for(Author::class, $request)
            ->with(['media'])
            ->collection()
        ;
    }

    #[Get('/{author_slug}', name: 'authors.show')]
    public function show(Request $request, Author $author)
    {
        return AuthorResource::make($author);
    }

    #[Get('/{author_slug}/books', name: 'authors.show.books')]
    public function books(Request $request, Author $author)
    {
        $books = $author->books()->with(['language', 'serie'])->get();

        return BookCollection::collection($books);
    }

    #[Get('/{author_slug}/series', name: 'authors.show.series')]
    public function series(Request $request, Author $author)
    {
        return SerieCollection::collection($author->series);
    }
}
