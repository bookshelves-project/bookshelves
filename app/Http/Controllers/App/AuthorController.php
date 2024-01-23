<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('authors')]
class AuthorController extends Controller
{
    #[Get('/', name: 'authors.index')]
    public function index()
    {
        $authors = Author::with(['media'])
            ->orderBy('slug')
            ->get()
            ->append(['cover_thumbnail', 'cover_color']);

        return inertia('Authors/Index', [
            'authors' => $authors,
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
