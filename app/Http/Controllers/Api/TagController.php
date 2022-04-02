<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PaginationHelper;
use App\Http\Queries\Addon\QueryOption;
use App\Http\Queries\TagQuery;
use App\Http\Resources\EntityResource;
use App\Http\Resources\Tag\TagLightResource;
use App\Http\Resources\Tag\TagResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Spatie\Tags\Tag;

/**
 * @group Relation: Tag
 */
class TagController extends ApiController
{
    /**
     * GET Tag[].
     *
     * Get all Tags ordered by 'name'.
     *
     * @queryParam type filters[tag,genre] Type of Tag, 'tag' by default. No-example
     *
     * @responseField name string Tag's name.
     */
    public function index(Request $request)
    {
        return app(TagQuery::class)
            ->make(QueryOption::create(
                request: $request,
                resource: TagLightResource::class,
                orderBy: 'slug->en',
                withExport: false,
                sortAsc: true,
                full: $this->getFull($request),
            ))
            ->paginateOrExport()
        ;
    }

    /**
     * GET Tag.
     *
     * Get Tag details.
     *
     * @queryParam type filters[tag,genre] Type of Tag, 'tag' by default. No-example
     */
    public function show(Tag $tag)
    {
        return TagResource::make($tag);
    }

    /**
     * GET Entity[] belongs to Tag.
     *
     * Get all Books and Series of selected Tag.
     */
    public function books(Tag $tag)
    {
        $books_standalone = Book::withAllTags([$tag])->with(['serie', 'authors', 'media'])->orderBy('slug_sort')->doesntHave('serie')->get();

        $books_series = Book::withAllTags([$tag])->with(['serie', 'authors', 'media', 'serie.media', 'serie.authors'])->has('serie')->orderBy('slug_sort')->get();
        $series = collect();
        $books_series->each(function ($book) use ($series) {
            $series->add($book->serie);
        });
        $series = $series->unique();

        $books = $books_standalone->merge($series);
        $books = $books->sortBy('slug_sort');

        return EntityResource::collection(PaginationHelper::paginate($books, 32));
    }
}
