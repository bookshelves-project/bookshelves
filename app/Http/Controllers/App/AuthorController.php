<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
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
        $query = HttpQuery::for(Author::class, $request)
            ->with(['media'])
            ->defaultSort('slug')
            ->inertia();

        return inertia('Authors/Index', [
            'title' => 'Authors',
            'query' => $query,
            'breadcrumbs' => [
                ['label' => 'Authors', 'route' => ['name' => 'authors.index']],
            ],
        ]);
    }

    #[Get('/{author_slug}', name: 'authors.show')]
    public function show(Author $author)
    {
        $author->load(['authors', 'serie', 'tags', 'media'])
            ->append(['cover_standard', 'cover_social', 'cover_color']);

        return inertia('Authors/Show', [
            'author' => $author,
        ]);
    }
}
