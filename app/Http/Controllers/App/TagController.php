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
    public function show(Tag $tag)
    {
        $books = Book::with(['tags'])
            ->whereHas('tags', fn ($query) => $query->where('tag_id', $tag->id))
            ->get();
        $series = Serie::with(['tags'])
            ->whereHas('tags', fn ($query) => $query->where('tag_id', $tag->id))
            ->get();

        return inertia('Tags/Show', [
            'tag' => $tag,
            'title' => "{$tag->name}",
            'models' => [
                ...$books,
                ...$series,
            ],
        ]);
    }
}
