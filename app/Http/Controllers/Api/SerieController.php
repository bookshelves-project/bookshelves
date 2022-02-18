<?php

namespace App\Http\Controllers\Api;

use App\Http\Queries\Addon\QueryOption;
use App\Http\Queries\SerieQuery;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\BookOrSerieResource;
use App\Http\Resources\Serie\SerieLightResource;
use App\Http\Resources\Serie\SerieResource;
use App\Models\Author;
use App\Models\Serie;
use Illuminate\Http\Request;

/**
 * @group Serie
 *
 * Endpoint to get Series data.
 */
class SerieController extends ApiController
{
    /**
     * GET List series.
     *
     * <small class="badge badge-blue">WITH PAGINATION</small>
     *
     * Get all series ordered by `title` & `serie_title`.
     *
     * @usesPagination
     *
     * @queryParam filter[languages] string
     * To select specific lang, `null` by default. Example: en,fr
     *
     * @responseField data object[] List of series.
     * @responseField links object Links to get other pages.
     * @responseField meta object Metadata about pagination.
     */
    public function index(Request $request)
    {
        $paginate = $request->parseBoolean('paginate');

        return app(SerieQuery::class)
            ->make(QueryOption::create(
                resource: SerieLightResource::class,
                orderBy: 'slug_sort',
                withExport: false,
                sortAsc: true,
                withPagination: $paginate
            ))
            ->paginateOrExport()
        ;
    }

    /**
     * GET Serie resource.
     *
     * Get details of Serie model, find by slug of serie and slug of author.
     */
    public function show(Author $author, Serie $serie)
    {
        return SerieResource::make($serie);
    }

    /**
     * GET Book collection of Serie.
     *
     * Books list from one Serie, find by slug.
     *
     * @usesPagination
     */
    public function books(Request $request, Author $author, Serie $serie)
    {
        $page = $request->get('perPage');
        $page = $page ? $page : 32;
        if (! is_numeric($page)) {
            return response()->json(
                "Invalid 'perPage' query parameter, must be an int",
                400
            );
        }
        $page = intval($page);

        // Author::whereSlug($author_slug)->firstOrFail();
        // $serie = Serie::whereSlug($serie_slug)->with(['books', 'books.media', 'books.authors', 'books.serie', 'books.language'])->firstOrFail();
        // if ($author_slug === $serie->meta_author) {
        $books = $serie->books()->paginate($page);

        return BookLightResource::collection($books);
        // }

        // return abort(404);
    }

    /**
     * GET Book collection of Serie (from volume).
     *
     * Books list from one Serie, find by slug from volume and limited to 10 results.
     */
    public function current(Request $request, string $volume, Author $author, Serie $serie)
    {
        $limit = $request->get('limit') ? filter_var($request->get('limit'), FILTER_VALIDATE_BOOLEAN) : null;
        $volume = intval($volume);

        // $author = Author::whereSlug($author)->firstOrFail();
        // $serie = Serie::whereHas('authors', function ($query) use ($author) {
        //     return $query->where('author_id', '=', $author->id);
        // })->whereSlug($serie)->first();

        $books = $serie->books;
        $books = $books->filter(function ($book) use ($volume) {
            return $book->volume > $volume;
        });
        $books = $books->splice(0, 10);
        if ($books->count() < 1) {
            $books = $serie->books;
            $books = $books->splice(0, 10);
        }

        return BookOrSerieResource::collection($books);
    }
}
