<?php

namespace App\Http\Controllers\Api;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Utils\BookshelvesTools;
use App\Http\Controllers\Controller;
use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Serie\SerieLightResource;
use App\Http\Resources\Author\AuthorLightResource;
use App\Http\Resources\Author\AuthorUltraLightResource;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @group Author
 */
class AuthorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/authors",
     *     tags={"authors"},
     *     summary="List of authors",
     *     description="Authors",
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
     *         description="Successful operation"
     *     )
     * )
     */

    /**
     * Authors list
     *
     * You can get all authors with alphabetic order on lastname with pagination.
     *
     * @queryParam per-page int Entities per page.
     * @queryParam page int The page number.
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
            $authors = Author::orderBy('lastname')->get();

            return AuthorUltraLightResource::collection($authors);
        }

        $authors = Author::with('media')->orderBy('lastname')->withCount('books')->get();

        // $authors = BookshelvesTools::chunkByAlpha($authors, 'lastname');
        // dd($authors);

        return AuthorLightResource::collection($authors->paginate($page));
    }

    /**
     * @primaryKey slug
     * @urlParam author string required The slug of author.
     * @response {
     *  "id": 4,
     *  "name": "Jessica Jones",
     *  "roles": ["admin"]
     * }
     *
     * @throws HttpException
     * @throws NotFoundHttpException
     *
     * @return AuthorResource|void
     */
    public function show(Author $author)
    {
        try {
            // $author = Author::whereSlug($author->slug)->with('media')->withCount('books')->firstOrFail();
            // $author = AuthorResource::make($author);

            // return $author;
            return '';
        } catch (\Throwable $th) {
            return abort(404);
        }
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
        $author = Author::whereSlug($author)->with(['series' => function ($query) {
            $query->withCount('books');
        }, 'series.media', 'series.authors', 'series.language', 'series.books'])->firstOrFail();

        return SerieLightResource::collection($author->series);
    }
}
