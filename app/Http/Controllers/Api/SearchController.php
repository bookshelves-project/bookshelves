<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\Serie;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Serie\SerieLightResource;
use App\Http\Resources\Search\SearchBookResource;
use App\Http\Resources\Author\AuthorLightResource;
use App\Http\Resources\Search\SearchSerieResource;
use App\Http\Resources\Search\SearchAuthorResource;

class SearchController extends Controller
{
    /**
     * @OA\Get(
     *     path="/search",
     *     tags={"search"},
     *     summary="List of search results",
     *     description="To search books, authors and series",
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="String value can be book's title, author's firstname or lastname, series' title",
     *         required=true,
     *         example="bottero",
     *         @OA\Schema(
     *           type="string",
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
        $searchTermRaw = $request->input('q');
        $searchTerm = mb_convert_encoding($searchTermRaw, 'UTF-8', 'UTF-8');
        if ($searchTermRaw) {
            $authors = Author::whereLike(['name', 'firstname', 'lastname'], $searchTerm)->get();
            $series = Serie::whereLike(['title', 'authors.name'], $searchTerm)->get();
            $books = Book::whereLike(['title', 'authors.name', 'serie.title'], $searchTerm)->orderBy('serie_id')->orderBy('serie_number')->get();

            $authors = SearchAuthorResource::collection($authors);
            $series = SearchSerieResource::collection($series);
            $books = SearchBookResource::collection($books);
            $collection = $authors->merge($series);
            $collection = $collection->merge($books);
            $collection->all();

            return response()->json([
                'data' => $collection,
            ]);
        }

        return response()->json(['error' => 'Need to have terms query parameter'], 401);
    }

    public function byBook(Request $request)
    {
        $searchTerm = $request->input('search-term');
        $books = Book::whereLike(['title'], $searchTerm)->orderBy('serie_id')->orderBy('serie_number')->get();

        return BookLightResource::collection($books);
    }

    public function byAuthor(Request $request)
    {
        $searchTerm = $request->input('search-term');
        $books = Book::whereLike(['author.name', 'author.firstname', 'author.lastname'], $searchTerm)->orderBy('serie_id')->orderBy('serie_number')->get();

        return AuthorLightResource::collection($books);
    }

    public function bySerie(Request $request)
    {
        $searchTerm = $request->input('search-term');
        $books = Book::whereLike(['serie.title'], $searchTerm)->orderBy('serie_id')->orderBy('serie_number')->get();

        return SerieLightResource::collection($books);
    }
}
