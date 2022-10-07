<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Book\BookCollectionResource;
use App\Http\Resources\Serie\SerieCollectionResource;
use App\Models\Author;
use Illuminate\Http\Request;
use Kiwilan\Steward\Queries\HttpQuery;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('authors')]
class AuthorController extends ApiController
{
    #[Get('/', name: 'authors.index')]
    public function index(Request $request)
    {
        return HttpQuery::make(Author::class, $request)
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
        return BookCollectionResource::collection($author->books);
    }

    #[Get('/{author_slug}/series', name: 'authors.show.series')]
    public function series(Request $request, Author $author)
    {
        return SerieCollectionResource::collection($author->series);
    }
}
