<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightestResource;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Book\BookResource;
use App\Http\Resources\BookOrSerieResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class BookController extends Controller
{
	/**
	 * @OA\Get(
	 *     path="/books",
	 *     tags={"books"},
	 *     summary="List of books",
	 *     description="Get list of books with some query parameters, check default value for each param",

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
		$lang = $request->get('lang');
		$lang = $lang ? $lang : null;
		$langParameters = ['fr', 'en'];
		if ($lang && !in_array($lang, $langParameters)) {
			return response()->json(
				"Invalid 'lang' query parameter, must be like '" . implode("' or '", $langParameters) . "'",
				400
			);
		}

		$perPage = $request->get('per-page') ? $request->get('per-page') : 32;
		if (!is_numeric($perPage)) {
			return response()->json(
				"Invalid 'per-page' query parameter, must be an int",
				400
			);
		}
		$perPage = intval($perPage);

		$serie = $request->get('serie') ? filter_var($request->get('serie'), FILTER_VALIDATE_BOOLEAN) : null;

		$books = Book::with(['serie', 'authors', 'media', 'serie.authors'])->orderBy('title_sort');

		// If lang
		if (null !== $lang) {
			Language::whereSlug($lang)->firstOrFail();
			$books = $books->whereLanguageSlug($lang);
		}
		// If serie
		if (null !== $serie) {
			if ($serie) {
				$books->has('serie');
			} else {
				$books->doesntHave('serie');
			}
		}

		$all = $request->get('all') ? filter_var($request->get('all'), FILTER_VALIDATE_BOOLEAN) : null;
		if ($all) {
			$books = Book::orderBy('title_sort')->get();

			return BookLightestResource::collection($books);
		}

		return BookLightResource::collection($books->paginate($perPage));
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
	public function show(Request $request, string $author_slug, string $book_slug)
	{
		$author = Author::whereSlug($author_slug)->firstOrFail();
		$book = $author->books->firstWhere('slug', $book_slug);
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
		if (!is_numeric($limit)) {
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

	public function selection(): JsonResource
	{
		$books = Book::inRandomOrder()->limit(10)->get();
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
					'id' => $lang->slug,
					'flag' => $lang->flag,
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

	public function related(string $authorSlug, string $bookSlug, Request $request)
	{
		$limit = $request->get('limit') ? filter_var($request->get('limit'), FILTER_VALIDATE_BOOLEAN) : false;

		// get book
		$author = Author::whereSlug($authorSlug)->first();
		$book = Book::whereHas('authors', function ($query) use ($author) {
			return $query->where('author_id', '=', $author->id);
		})->whereSlug($bookSlug)->firstOrFail();
		// get book tags
		$tags = $book->tags;

		// if tags
		if (sizeof($tags) >= 1) {
			// get related books by tags, same lang, limited to 10 results
			$related_books = Book::withAllTags($tags)->whereLanguageSlug($book->language_slug)->get();
			$related_books = $this->filterRelatedBooks($book, $related_books, $limit);

			if ($related_books->count() <= 1) {
				$related_books = Book::withAnyTags($tags)->whereLanguageSlug($book->language_slug)->get();
				$related_books = $this->filterRelatedBooks($book, $related_books, $limit);
			}

			return BookOrSerieResource::collection($related_books);
		}

		return response()->json(
			'No tags',
			400
		);
	}

	public function filterRelatedBooks(Book $book, Collection $related_books, bool $limit): Collection
	{
		// get serie of current book
		$serie_books = Serie::whereSlug($book->serie?->slug)->first();
		// get books of this serie
		$serie_books = $serie_books?->books;

		// if serie exist
		if ($serie_books) {
			// remove all books from this serie
			$filtered = $related_books->filter(function ($book) use ($serie_books) {
				foreach ($serie_books as $serie_book) {
					if ($book->serie) {
						return $book->serie->slug != $serie_book->serie->slug;
					}
				}
			});
			$related_books = $filtered;
		}
		// remove current book
		$related_books = $related_books->filter(function ($related_book) use ($book) {
			return $related_book->slug != $book->slug;
		});

		// get series of related
		$series_list = collect();
		foreach ($related_books as $key => $book) {
			if ($book->serie) {
				$series_list->add($book->serie);
			}
		}
		// remove all books of series
		$related_books = $related_books->filter(function ($book) {
			return null === $book->serie;
		});

		// unique on series
		$series_list = $series_list->unique();

		// merge books and series
		$related_books = $related_books->merge($series_list);

		// sort entities
		$related_books = $related_books->sortBy('title_sort');

		// set limit
		if ($limit) {
			$related_books = $related_books->slice(0, 10);
		}

		return $related_books;
	}
}
