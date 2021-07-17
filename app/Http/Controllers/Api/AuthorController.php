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
 *
 * Endpoint to get Authors data.
 */
class AuthorController extends Controller
{
    /**
     * GET Author collection
     *
     * You can get all authors with alphabetic order on lastname with pagination.
     *
     * @queryParam per-page int Entities per page, 32 by default. Example: 32.
     * @queryParam page int The page number, 1 by default. No-example
     * @responseFile public/storage/responses/authors.get.json
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
     * GET Author resource
     *
     * Details for one author, find by slug.
     *
     * @urlParam slug string required The slug of author like 'lovecraft-howard-phillips'. Example: lovecraft-howard-phillips
     * @responseFile public/storage/responses/authors-show.get.json
     *
     */
    public function show(Author $author)
    {
        try {
            $author = AuthorResource::make($author);

            return $author;
        } catch (\Throwable $th) {
            return response()->json(['failed' => 'No result for '.$author], 404);
        }
    }

    /**
     * GET Book collection of Author
     *
     * Books list from one author, find by slug.
     *
     * @queryParam per-page int Entities per page, 32 by default. Example: 32.
     * @queryParam page int The page number, 1 by default. No-example
     * @urlParam author_slug string required The slug of author like 'lovecraft-howard-phillips'. Example: lovecraft-howard-phillips
     * @responseFile public/storage/responses/authors-books.get.json
     *
     */
    public function books(Request $request, string $author)
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

        $standalone = $request->get('standalone') ? filter_var($request->get('standalone'), FILTER_VALIDATE_BOOLEAN) : false;

        if ($standalone) {
            $author = Author::whereSlug($author)->with(['books.media', 'books.authors', 'books.serie', 'books.language'])->with(['books' => function ($book) {
                return $book->whereDoesntHave('serie');
            }])->firstOrFail();
        } else {
            $author = Author::whereSlug($author)->with(['books.media', 'books.authors', 'books.serie', 'books.language'])->firstOrFail();
        }

        return BookLightResource::collection($author->books->paginate($page));
    }

    /**
     * GET Serie collection of Author
     *
     * Series list from one author, find by slug.
     *
     * @queryParam per-page int Entities per page, 32 by default. Example: 32.
     * @queryParam page int The page number, 1 by default. No-example
     * @urlParam author_slug string required The slug of author like 'lovecraft-howard-phillips'. Example: lovecraft-howard-phillips
     * @responseFile public/storage/responses/authors-series.get.json
     *
     */
    public function series(Request $request, string $author)
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

        $author = Author::whereSlug($author)->with(['series' => function ($query) {
            $query->withCount('books');
        }, 'series.media', 'series.authors', 'series.language', 'series.books'])->firstOrFail();

        return SerieLightResource::collection($author->series->paginate($page));
    }
}
