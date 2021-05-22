<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\Author;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\Book\BookResource;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Book\BookMobileResource;
use App\Http\Resources\Book\BookLightestResource;

class BookController extends Controller
{
    /**
     * @OA\Get(
     *     path="/books",
     *     tags={"books"},
     *     summary="List of books",
     *     description="Get list of books with some query parameters, check default value for each param",
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="To show books with pagination, all books with light version or full version, default value: 'pagination'",
     *         required=false,
     *         @OA\Schema(
     *           enum={"pagination", "all", "full"}
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="per-page",
     *         in="query",
     *         description="Integer to choose how many books you show in each page, default valuel: '32'",
     *         required=false,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         ),
     *         style="form"
     *     ),
     *     @OA\Parameter(
     *         name="lang",
     *         in="query",
     *         description="String to select existant eBook language, default value: null",
     *         required=false,
     *         @OA\Schema(
     *           enum={"fr", "en"},
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function index(Request $request)
    {
        // OPTIONS
        // TODO reject if not type
        $lang = $request->get('lang');
        $lang = $lang ? $lang : null;
        $langParameters = ['fr', 'en'];
        if ($lang && ! in_array($lang, $langParameters)) {
            return response()->json(
                "Invalid 'lang' query parameter, must be like '" . implode("' or '", $langParameters) . "'",
                400
            );
        }

        $perPage = $request->get('per-page');
        $perPage = $perPage ? $perPage : 32;
        if (! is_numeric($perPage)) {
            return response()->json(
                "Invalid 'per-page' query parameter, must be an int",
                400
            );
        }
        $perPage = intval($perPage);

        $limit = $request->get('limit');
        $limit = $limit ? $limit : 'pagination';
        $limitParameters = ['pagination', 'all', 'full'];
        if (! in_array($limit, $limitParameters)) {
            return response()->json(
                "Invalid 'limit' query parameter, must be like '" . implode("' or '", $limitParameters) . "'",
                400
            );
        }

        $mobile = filter_var($request->get('mobile'), FILTER_VALIDATE_BOOLEAN);

        if ($lang) {
            Cache::forget('books');
            $cachedBooks = null;
        } else {
            $cachedBooks = Cache::get('books');
        }

        if (! $cachedBooks) {
            if ($lang) {
                Language::whereSlug($lang)->firstOrFail();
                $books = Book::whereLanguageSlug($lang)->get();
            } else {
                $books = Book::all();
            }
            $books = $books->sortBy(function ($book) {
                return $book->sort_name;
            });
            if (! $lang) {
                Cache::remember('books', 86400, function () use ($books) {
                    return $books;
                });
            }
        } else {
            $books = $cachedBooks;
        }

        switch ($limit) {
            case 'pagination':
                $books = $books->paginate($perPage);
                $books = BookLightResource::collection($books);

                break;

            case 'all':
                $books = BookLightestResource::collection($books);

                break;

            case 'full':
                $books = BookLightResource::collection($books);

                break;

            default:
                $books = $books->paginate($perPage);
                $books = BookLightResource::collection($books);

                break;
        }

        if ($mobile) {
            $books = BookMobileResource::collection($books);

            return $books;
        }
        // dd($books);

        return $books;
    }

    /**
     * @OA\Get(
     *     path="/books/{author-slug}/{book-slug}",
     *     summary="Show book by author slug and book slug",
     *     tags={"books"},
     *     description="Get details for a single book, check /books endpoint to get list of slugs",
     *     operationId="findBookByAuthorSlugBookSlug",
     *     @OA\Parameter(
     *         name="author-slug",
     *         in="path",
     *         description="Slug of author name like 'auel-jean-m' for Jean M. Auel",
     *         required=true,
     *         example="auel-jean-m",
     *         @OA\Schema(
     *           type="string",
     *           @OA\Items(type="string"),
     *         ),
     *         style="form"
     *     ),
     *     @OA\Parameter(
     *         name="book-slug",
     *         in="path",
     *         description="Slug of book name like 'les-refuges-de-pierre' for Les refuges de pierre",
     *         required=true,
     *         example="les-refuges-de-pierre",
     *         @OA\Schema(
     *           type="string",
     *           @OA\Items(type="string"),
     *         ),
     *         style="form"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\Schema(ref="#/components/schemas/ApiResponse")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Invalid author-slug value or book-slug value",
     *         @OA\Schema(ref="#/components/schemas/ApiResponse")
     *     ),
     * )
     */
    public function show(Request $request, string $author, string $book)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $book = Book::whereHas('authors', function ($query) use ($author) {
            return $query->where('author_id', '=', $author->id);
        })->whereSlug($book)->firstOrFail();
        $book = BookResource::make($book);

        return $book;
    }

    public function update(Request $request)
    {
        $books = Book::limit(5)->get();

        return $books;
    }

    /**
     * @OA\Get(
     *     path="/books/latest",
     *     tags={"books"},
     *     summary="List of latest books",
     *     description="Get list of latest books",
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Integer to choose how many books you show, default value: '10'",
     *         required=false,
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
    public function latest(Request $request)
    {
        $limit = $request->get('limit');
        $limit = $limit ? $limit : 10;
        if (! is_numeric($limit)) {
            return response()->json(
                "Invalid 'limit' query parameter, must be an int",
                400
            );
        }
        $limit = intval($limit);

        $books = Book::orderByDesc('created_at')->limit($limit)->get();
        $books = BookLightResource::collection($books);

        return $books;
    }

    /**
     * @OA\Get(
     *     path="/books/count-langs",
     *     tags={"books"},
     *     summary="Count for books by lang",
     *     description="Count books by lang",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function count_langs()
    {
        $langs = Language::with('books')->get();
        $langs_books = collect($langs)
            ->map(function ($lang) {
                return [
                    'id'    => $lang->slug,
                    'flag'  => $lang->flag,
                    'count' => $lang->books->count(),
                ];
            })
            ->all();

        return $langs_books;
    }

    /**
     * @OA\Get(
     *     path="/books/count",
     *     tags={"books"},
     *     summary="Count for books",
     *     description="Count books",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function count()
    {
        return Book::count();
    }
}
