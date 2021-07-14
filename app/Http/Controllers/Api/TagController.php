<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Spatie\Tags\Tag;
use App\Models\TagExtend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EntityResource;
use App\Http\Resources\Tag\TagResource;
use App\Http\Resources\Tag\TagLightResource;

/**
 * @group Tag
 */
class TagController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type');
        $type = $type ? $type : 'tag';
        $typeParameters = ['tag', 'genre'];
        if ($type && ! in_array($type, $typeParameters)) {
            return response()->json(
                "Invalid 'type' query parameter, must be like '".implode("' or '", $typeParameters)."'",
                400
            );
        }

        $tags = TagExtend::whereType($type)->withCount('books')->orderBy('slug->en')->get();

        return TagLightResource::collection($tags);
    }

    public function show(string $tag_slug)
    {
        $tag = Tag::where('slug->en', $tag_slug)->first();

        return TagResource::make($tag);
    }

    public function books(string $tag_slug)
    {
        $tag = Tag::where('slug->en', $tag_slug)->first();
        $books_standalone = Book::withAllTags([$tag])->with(['serie', 'authors', 'media'])->orderBy('title_sort')->doesntHave('serie')->get();

        $books_series = Book::withAllTags([$tag])->with(['serie', 'authors', 'media', 'serie.media', 'serie.authors'])->has('serie')->orderBy('title_sort')->get();
        $series = collect();
        $books_series->each(function ($book) use ($series) {
            $series->add($book->serie);
        });
        $series = $series->unique();

        $books = $books_standalone->merge($series);
        $books = $books->sortBy('title_sort');

        return EntityResource::collection($books->paginate(32));
    }
}
