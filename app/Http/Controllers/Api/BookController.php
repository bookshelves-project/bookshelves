<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\Author;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\BookCollection;

class BookController extends Controller
{
    /**
     * @OA\Get(
     *     path="/books",
     *     tags={"books"},
     *     summary="List of books",
     *     description="Books",
     *     @OA\Parameter(
     *         name="all",
     *         in="query",
     *         description="Boolean to show all books without pagination",
     *         required=false,
     *         example=false,
     *         @OA\Schema(
     *           type="boolean",
     *           @OA\Items(type="boolean"),
     *         ),
     *         style="form"
     *     ),
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
        $selectByLang = $request->input('lang');
        $perPage = $request->get('perPage');
        $all = $request->get('all');
        $all = filter_var($all, FILTER_VALIDATE_BOOLEAN);
        $debug = $request->get('debug');
        if (null === $perPage) {
            $perPage = 32;
        }

        if ($selectByLang) {
            Cache::clear('books');
            $cachedBooks = null;
        } else {
            $cachedBooks = Cache::get('books');
        }
        
        if (! $cachedBooks) {
            $booksWithSerie = Book::whereNotNull('serie_id')->orderBy('serie_id')->orderBy('serie_number');
            $booksWithoutSerie = Book::whereNull('serie_id');
            if ($selectByLang) {
                Language::whereSlug($selectByLang)->firstOrFail();
                $booksWithSerie = $booksWithSerie->whereLanguageSlug($selectByLang);
                $booksWithoutSerie = $booksWithoutSerie->whereLanguageSlug($selectByLang);
            }
            $booksWithSerie = $booksWithSerie->get();
            $booksWithoutSerie = $booksWithoutSerie->get();

            $books = $booksWithSerie->merge($booksWithoutSerie);
            $books = $books->sortBy(function ($book, $key) {
                $title = null;
                if ($book->serie) {
                    $title = $book->serie->title_sort;
                    $title = ucfirst($title.$book->serie_number);
                } else {
                    $title = ucfirst($book->title_sort);
                }

                return $title;
            }, SORT_NATURAL);
            if (!$selectByLang) {
                Cache::remember('books', 120, function () use ($books) {
                    return $books;
                });
            }
            
        } else {
            $books = $cachedBooks;
        }

        if (! $all) {
            $books = $books->paginate($perPage);
        }
        $books = BookCollection::collection($books);

        if ($debug) {
            foreach ($books as $book) {
                if ($book->serie) {
                    echo $book->serie->title_sort.' '.$book->serie_number.' '.$book->title_sort.'<br>';
                } else {
                    echo $book->title_sort.'<br>';
                }
            }
        } else {
            return $books;
        }
    }

    public function count()
    {
        return Book::count();
    }

    /**
     * @OA\Get(
     *     path="/books/{author-slug}/{book-slug}",
     *     summary="Show book by author slug and book slug",
     *     tags={"books"},
     *     description="Muliple tags can be provided with comma separated strings. Use tag1, tag2, tag3 for testing.",
     *     operationId="findBookByAuthorSlugBookSlug",
     *     @OA\Parameter(
     *         name="author-slug",
     *         in="path",
     *         description="Slug of author name like 'auel-jean' for Jean Auel",
     *         required=true,
     *         example="auel-jean",
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
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Pet")
     *         ),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid author-slug value or book-slug value",
     *     ),
     * )
     */
    public function show(Request $request, string $author, string $book)
    {
        // $book = Book::whereHas('authors', function ($query) use ($author) {
        //     return $query->where('slug', '=', $author);
        // })->where('serie_number', '=', '1')->get();
        // dd($book);
        // $book = BookResource::make($book);
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

        // return response()->json('Success, you have access to Bookshelves');
        return $books;
    }

    public function latest()
    {
        $books = Book::orderByDesc('created_at')->limit(10)->get();
        $books = BookCollection::collection($books);

        return $books;
    }

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
}
