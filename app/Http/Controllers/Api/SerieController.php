<?php

namespace App\Http\Controllers\Api;

use App\Models\Serie;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookOrSerieResource;
use App\Http\Resources\Serie\SerieResource;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Serie\SerieLightResource;
use App\Http\Resources\Serie\SerieUltraLightResource;

/**
 * @group Serie
 */
class SerieController extends Controller
{
    /**
     * @OA\Get(
     *     path="/series",
     *     tags={"series"},
     *     summary="List of series",
     *     description="Series",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Integer to choose how many books you show in each page",
     *         required=false,
     *         example=32,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         ),
     *         style="form"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     * 		   @OA\JsonContent(),
     *     )
     * )
     */

    /**
    * @response {
    *  "id": 4,
    *  "name": "Jessica Jones",
    *  "roles": ["admin"]
    * }
    */
    public function index(Request $request)
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

        $all = $request->get('all') ? filter_var($request->get('all'), FILTER_VALIDATE_BOOLEAN) : null;
        if ($all) {
            $series = Serie::orderBy('title_sort')->get();

            return SerieUltraLightResource::collection($series);
        }

        $series = Serie::with(['authors', 'media'])->orderBy('title_sort')->withCount('books')->paginate($page);

        return SerieLightResource::collection($series);
    }

    /**
     * @OA\Get(
     *     path="/series/{author}/{series}",
     *     summary="Show series by author slug and by series slug",
     *     tags={"series"},
     *     description="Get details for a single series with list of books, check /series endpoint to get list of slugs",
     *     operationId="findAuthorByAuthorSlug",
     *     @OA\Parameter(
     *         name="author",
     *         in="path",
     *         description="Slug of author name like 'lovecraft-howard-phillips' for Howard Phillips Lovecraft",
     *         required=true,
     *         example="lovecraft-howard-phillips",
     *         style="form"
     *     ),
     *     @OA\Parameter(
     *         name="series",
     *         in="path",
     *         description="Slug of book name like 'cthulhu-le-mythe-fr' for Cthulhu : Le Mythe",
     *         required=true,
     *         example="cthulhu-le-mythe-fr",
     *         style="form"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(),
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Invalid author-slug value or book-slug value",
     *         @OA\JsonContent(),
     *     ),
     * )
     */

    /**
    * @response {
    *  "id": 4,
    *  "name": "Jessica Jones",
    *  "roles": ["admin"]
    * }
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
     * @response {
     *  "id": 4,
     *  "name": "Jessica Jones",
     *  "roles": ["admin"]
     * }
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
     * @response {
     *  "id": 4,
     *  "name": "Jessica Jones",
     *  "roles": ["admin"]
     * }
     */
    public function showCurrent(Request $request, string $volume, string $author, string $serie)
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
