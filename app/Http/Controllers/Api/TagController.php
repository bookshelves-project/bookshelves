<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\EntityResource;
use App\Http\Resources\Tag\TagResource;
use App\Models\Book;
use App\Models\TagExtend;
use Illuminate\Http\Request;
use Kiwilan\Steward\Queries\HttpQuery;
use Kiwilan\Steward\Utils\PaginatorHelper;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('tags')]
class TagController extends Controller
{
    #[Get('/', name: 'api.tags.index')]
    public function index(Request $request)
    {
        return HttpQuery::for(TagExtend::class, $request)
            ->collection()
        ;
    }

    #[Get('/{tag_slug}', name: 'api.tags.show')]
    public function show(TagExtend $tag)
    {
        return TagResource::make($tag);
    }

    #[Get('/{tag_slug}/books', name: 'api.tags.show.books')]
    public function books(TagExtend $tag)
    {
        $books_standalone = Book::withAllTags([$tag])
            ->with(['serie', 'authors', 'media'])
            ->orderBy('slug_sort')
            ->doesntHave('serie')
            ->get()
        ;

        $books_series = Book::withAllTags([$tag])
            ->with(['serie', 'authors', 'media', 'serie.media', 'serie.authors'])
            ->has('serie')
            ->orderBy('slug_sort')
            ->get()
        ;
        $series = collect();
        $books_series->each(function ($book) use ($series) {
            $series->add($book->serie);
        });
        $series = $series->unique();

        $books = $books_standalone->merge($series);
        $books = $books->sortBy('slug_sort');

        return EntityResource::collection(PaginatorHelper::paginate($books, 32));
    }
}
