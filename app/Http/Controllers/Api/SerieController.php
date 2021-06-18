<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\BookOrSerieResource;
use App\Http\Resources\Serie\SerieLightResource;
use App\Http\Resources\Serie\SerieResource;
use App\Http\Resources\Serie\SerieUltraLightResource;
use App\Models\Author;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SerieController extends Controller
{
	/**
	 * @OA\Get(
	 *     path="/series",
	 *     tags={"series"},
	 *     summary="List of series",
	 *     description="Series",
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
		if (!is_numeric($perPage)) {
			return response()->json(
				"Invalid 'per-page' query parameter, must be an int",
				400
			);
		}
		$perPage = intval($perPage);

		$all = $request->get('all') ? filter_var($request->get('all'), FILTER_VALIDATE_BOOLEAN) : null;
		if ($all) {
			$series = Serie::orderBy('title_sort')->get();

			return SerieUltraLightResource::collection($series);
		}

		$cachedSeries = Cache::get('series');
		if (!$cachedSeries) {
			$series = Serie::with(['authors', 'media'])->orderBy('title_sort')->withCount('books')->paginate($perPage);

			Cache::remember('series', 86400, function () use ($series) {
				return $series;
			});
		} else {
			$series = $cachedSeries;
		}

		return SerieLightResource::collection($series);
	}

	/**
	 * @OA\Get(
	 *     path="/series/{author-slug}/{series-slug}",
	 *     summary="Show series by author slug and by series slug",
	 *     tags={"series"},
	 *     description="Get details for a single series with list of books, check /series endpoint to get list of slugs",
	 *     operationId="findAuthorByAuthorSlug",
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
	 *         name="series-slug",
	 *         in="path",
	 *         description="Slug of series name like 'les-enfants-de-la-terre' for Les enfants de la terre",
	 *         required=true,
	 *         example="les-enfants-de-la-terre",
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
	public function show(string $author, string $serie)
	{
		$author = Author::whereSlug($author)->firstOrFail();
		$serie = Serie::whereHas('authors', function ($query) use ($author) {
			return $query->where('author_id', '=', $author->id);
		})->whereSlug($serie)->first();

		return SerieResource::make($serie);
	}

	public function books(string $author_slug, string $serie_slug)
	{
		Author::whereSlug($author_slug)->firstOrFail();
		$serie = Serie::whereSlug($serie_slug)->with(['books', 'books.media', 'books.authors', 'books.serie', 'books.language'])->firstOrFail();
		if ($author_slug === $serie->meta_author) {
			$books = $serie->books;

			return BookLightResource::collection($books);
		}

		return abort(404);
	}

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

	/**
	 * @OA\Get(
	 *     path="/series/count",
	 *     tags={"series"},
	 *     summary="Count for series",
	 *     description="Count series",
	 *     @OA\Response(
	 *         response=200,
	 *         description="Successful operation"
	 *     )
	 * )
	 */
	public function count()
	{
		return Serie::count();
	}
}
