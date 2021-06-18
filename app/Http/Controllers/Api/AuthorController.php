<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Author\AuthorLightResource;
use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Author\AuthorUltraLightResource;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Serie\SerieLightResource;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
		if (!is_numeric($perPage)) {
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

		$cachedAuthors = Cache::get('authors');

		if (!$cachedAuthors) {
			$authors = Author::with('media')->orderBy('lastname')->withCount('books')->paginate($perPage);

			Cache::remember('authors', 86400, function () use ($authors) {
				return $authors;
			});
		} else {
			$authors = $cachedAuthors;
		}

		return AuthorLightResource::collection($authors);
	}

	/**
	 * @OA\Get(
	 *     path="/authors/{author-slug}",
	 *     summary="Show author by author slug",
	 *     tags={"authors"},
	 *     description="Get details for a single author with list of series and books, check /authors endpoint to get list of slugs",
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
	public function show(string $author)
	{
		$author = Author::whereSlug($author)->with('media')->withCount('books')->firstOrFail();
		$author = AuthorResource::make($author);

		return $author;
	}

	public function books(string $author)
	{
		$author = Author::whereSlug($author)->with(['books.media', 'books.authors', 'books.serie', 'books.language'])->firstOrFail();

		return BookLightResource::collection($author->books);
	}

	public function series(string $author)
	{
		$author = Author::whereSlug($author)->with(['series.media', 'series.authors', 'series.language'])->firstOrFail();

		return SerieLightResource::collection($author->series);
	}

	/**
	 * @OA\Get(
	 *     path="/authors/count",
	 *     tags={"authors"},
	 *     summary="Count for authors",
	 *     description="Count authors",
	 *     @OA\Response(
	 *         response=200,
	 *         description="Successful operation"
	 *     )
	 * )
	 */
	public function count()
	{
		return Author::count();
	}
}
