<?php

namespace App\Http\Controllers\Api;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Serie\SerieLightResource;
use App\Http\Resources\Author\AuthorLightResource;
use App\Http\Resources\Author\AuthorUltraLightResource;

class AuthorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/authors",
     *     tags={"authors"},
     *     summary="List of authors",
     *     description="Authors",
     *     @OA\Parameter(
     *         name="perPage",
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
     *         description="Successful operation"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per-page');
        $perPage = $perPage ? $perPage : 32;
        if (! is_numeric($perPage)) {
            return response()->json(
                "Invalid 'per-page' query parameter, must be an int",
                400
            );
        }
        $perPage = intval($perPage);

        $all = $request->get('all') ? filter_var($request->get('all'), FILTER_VALIDATE_BOOLEAN) : null;
        if ($all) {
            $authors = Author::orderBy('lastname')->get();

            return AuthorUltraLightResource::collection($authors);
        }

        $authors = Author::with('media')->orderBy('lastname')->withCount('books')->paginate($perPage);

        return AuthorLightResource::collection($authors);
    }

    /**
     * @OA\Get(
     *     path="/authors/{author}",
     *     summary="Show author by author slug",
     *     tags={"authors"},
     *     description="Get details for a single author with list of series and books, check /authors endpoint to get list of slugs",
     *     operationId="findAuthorByAuthorSlug",
     *     @OA\Parameter(
     *         name="author",
     *         in="path",
     *         description="Slug of author name like 'auel-jean-m' for Jean M. Auel",
     *         required=true,
     *         example="auel-jean-m",
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
    public function show(string $author)
    {
        $author = Author::whereSlug($author)->with('media')->withCount('books')->firstOrFail();
        $author = AuthorResource::make($author);

        return $author;
    }

    public function books(Request $request, string $author)
    {
        $standalone = $request->get('standalone') ? filter_var($request->get('standalone'), FILTER_VALIDATE_BOOLEAN) : false;

        if ($standalone) {
            $author = Author::whereSlug($author)->with(['books.media', 'books.authors', 'books.serie', 'books.language'])->with(['books' => function ($book) {
                return $book->whereDoesntHave('serie');
            }])->firstOrFail();
        } else {
            $author = Author::whereSlug($author)->with(['books.media', 'books.authors', 'books.serie', 'books.language'])->firstOrFail();
        }

        return BookLightResource::collection($author->books);
    }

    public function series(string $author)
    {
        $author = Author::whereSlug($author)->with(['series.media', 'series.authors', 'series.language'])->firstOrFail();

        return SerieLightResource::collection($author->series);
    }
}
