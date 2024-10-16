<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Serie;
use App\Models\Tag;
use Illuminate\Http\Request;
use Kiwilan\Steward\Queries\HttpQuery;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('tags')]
class TagController extends Controller
{
    #[Get('/', name: 'tags.index')]
    public function index(Request $request)
    {
        return inertia('Tags/Index', [
            'query' => HttpQuery::for(Tag::class, $request)
                ->withCount(['books', 'series'])
                ->inertia(),
            'title' => 'Tags',
        ]);
    }

    #[Get('/{tag:slug}', name: 'tags.show')]
    public function show(Request $request, Tag $tag)
    {
        return inertia('Tags/Show', [
            'tag' => $tag,
            'title' => "{$tag->name}",
            'query' => HttpQuery::for(
                Book::with(['media', 'authors', 'serie', 'library', 'language', 'tags'])->whereTagIs($tag),
                $request,
            )->inertia(),
            'breadcrumbs' => [
                ['label' => $tag->name, 'route' => ['name' => 'tags.show', 'params' => ['tag' => $tag->slug]]],
            ],
            'square' => false,
            'series' => false,
        ]);
    }

    #[Get('/{tag:slug}/series', name: 'tags.show.series')]
    public function showSeries(Request $request, Tag $tag)
    {
        return inertia('Tags/Show', [
            'tag' => $tag,
            'title' => "{$tag->name}",
            'query' => HttpQuery::for(
                Serie::with(['media', 'authors', 'library', 'language', 'tags'])->whereTagIs($tag),
                $request,
            )->inertia(),
            'breadcrumbs' => [
                ['label' => $tag->name, 'route' => ['name' => 'tags.show', 'params' => ['tag' => $tag->slug]]],
            ],
            'series' => true,
        ]);
    }
}
