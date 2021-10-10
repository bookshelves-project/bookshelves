<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\BookOrSerieResource;
use App\Http\Resources\Serie\SerieLightResource;
use App\Http\Resources\Serie\SerieResource;
use App\Http\Resources\Serie\SerieUltraLightResource;
use App\Models\Author;
use App\Models\Language;
use App\Models\Serie;
use Illuminate\Http\Request;

/**
 * @group Serie
 *
 * Endpoint to get Series data.
 */
class SerieController extends Controller
{
    /**
     * GET Serie collection.
     *
     * <small class="badge badge-blue">WITH PAGINATION</small>
     *
     * Get all Series ordered by 'title'.
     *
     * @queryParam per-page int Entities per page, '32' by default. No-example
     * @queryParam page int The page number, '1' by default. No-example
     * @queryParam all bool To disable pagination, false by default. No-example
     * @queryParam lang filters[fr,en] To select specific lang, null by default. No-example
     *
     * @responseFile public/assets/responses/series.index.get.json
     */
    public function index(Request $request)
    {
        $lang = $request->get('lang');
        $lang = $lang ? $lang : null;
        $langParameters = ['fr', 'en'];
        if ($lang && ! in_array($lang, $langParameters)) {
            return response()->json(
                "Invalid 'lang' query parameter, must be like '".implode("' or '", $langParameters)."'",
                400
            );
        }

        $page = $request->get('per-page');
        $page = $page ? $page : 32;
        if (! is_numeric($page)) {
            return response()->json(
                "Invalid 'per-page' query parameter, must be an int",
                400
            );
        }
        $page = intval($page);

        $all = $request->get('all') ? filter_var($request->get('all'), FILTER_VALIDATE_BOOLEAN) : null;
        if ($all) {
            $series = Serie::orderBy('title_sort')->get();

            return SerieUltraLightResource::collection($series);
        }

        $series = Serie::with(['authors', 'media'])->orderBy('title_sort')->withCount('books');

        if (null !== $lang) {
            Language::whereSlug($lang)->firstOrFail();
            $series = $series->whereLanguageSlug($lang);
        }

        $series = $series->paginate($page);

        return SerieLightResource::collection($series);
    }

    /**
     * GET Serie resource.
     *
     * Get details of Serie model, find by slug of serie and slug of author.
     *
     * @urlParam author_slug string required The slug of author like 'lovecraft-howard-phillips'. Example: lovecraft-howard-phillips
     * @urlParam serie_slug string required The slug of serie like 'les-montagnes-hallucinees-fr'. Example: les-montagnes-hallucinees-fr
     *
     * @responseFile public/assets/responses/series.show.get.json
     */
    public function show(string $author, string $serie)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $serie = Serie::whereHas('authors', function ($query) use ($author) {
            return $query->where('author_id', '=', $author->id);
        })->whereSlug($serie)->withCount('books')->first();

        return SerieResource::make($serie);
    }

    /**
     * GET Book collection of Serie.
     *
     * Books list from one Serie, find by slug.
     *
     * @queryParam per-page int Entities per page, '32' by default. No-example
     * @queryParam page int The page number, '1' by default. No-example
     * @urlParam author_slug string required The slug of author like 'lovecraft-howard-phillips'. Example: lovecraft-howard-phillips
     * @urlParam serie_slug string required The slug of serie like 'les-montagnes-hallucinees-fr'. Example: les-montagnes-hallucinees-fr
     *
     * @responseFile public/assets/responses/series.books.get.json
     */
    public function books(Request $request, string $author_slug, string $serie_slug)
    {
        $page = $request->get('per-page');
        $page = $page ? $page : 32;
        if (! is_numeric($page)) {
            return response()->json(
                "Invalid 'per-page' query parameter, must be an int",
                400
            );
        }
        $page = intval($page);

        Author::whereSlug($author_slug)->firstOrFail();
        $serie = Serie::whereSlug($serie_slug)->with(['books', 'books.media', 'books.authors', 'books.serie', 'books.language'])->firstOrFail();
        if ($author_slug === $serie->meta_author) {
            $books = $serie->books;

            return BookLightResource::collection($books->paginate($page));
        }

        return abort(404);
    }

    /**
     * GET Book collection of Serie (from volume).
     *
     * Books list from one Serie, find by slug from volume and limited to 10 results.
     *
     * @urlParam author_slug string required The slug of author like '1'. Example: 1
     * @urlParam author_slug string required The slug of author like 'lovecraft-howard-phillips'. Example: lovecraft-howard-phillips
     * @urlParam serie_slug string required The slug of serie like 'les-montagnes-hallucinees-fr'. Example: les-montagnes-hallucinees-fr
     *
     * @responseFile public/assets/responses/series.current.get.json
     */
    public function current(Request $request, string $volume, string $author, string $serie)
    {
        $limit = $request->get('limit') ? filter_var($request->get('limit'), FILTER_VALIDATE_BOOLEAN) : null;
        $volume = intval($volume);

        $author = Author::whereSlug($author)->firstOrFail();
        $serie = Serie::whereHas('authors', function ($query) use ($author) {
            return $query->where('author_id', '=', $author->id);
        })->whereSlug($serie)->first();

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
