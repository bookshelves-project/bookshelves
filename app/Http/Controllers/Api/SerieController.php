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
use App\Services\DownloadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Support\MediaStream;

/**
 * @group Entity: Serie
 *
 * Endpoint to get Series data.
 */
class SerieController extends ApiController
{
    /**
     * GET Serie[].
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
     * GET Serie.
     *
     * Get details of Serie model, find by slug of serie and slug of author.
     */
    public function show(Author $author, Serie $serie)
    {
        return SerieResource::make($serie);
    }

    /**
     * GET Book[] belongs to Serie.
     *
     * Books list from one Serie, find by slug.
     *
     * @usesPagination
     */
    public function books(Request $request, Author $author, Serie $serie)
    {
        return BookLightResource::collection(
            $serie->booksAvailable()
                ->paginate(32)
        );
    }

    /**
     * GET Book[] belongs to Serie (from volume).
     *
     * Books list from one Serie, find by slug from volume and limited to 10 results.
     */
    public function current(Request $request, int $volume, Author $author, Serie $serie)
    {
        if ($serie->books->count() < 1) {
            $books = $serie->books;
        } else {
            $books = $serie->books->filter(fn ($book) => $book->volume > intval($volume));
        }

        return BookOrSerieResource::collection($books->splice(0, 10));
    }
}
