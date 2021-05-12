<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Utils\BookshelvesTools;
use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Serie\SerieLightResource;
use App\Http\Resources\Author\AuthorLightResource;

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
        if ($searchTermRaw) {
            $collection = BookshelvesTools::searchGlobal($searchTermRaw);

            return response()->json([
                'data' => $collection,
            ]);
        }

        return response()->json(['error' => 'Need to have terms query parameter'], 401);
    }

    public function byBook(Request $request)
    {
        $searchTerm = $request->input('search-term');
        $books = Book::whereLike(['title'], $searchTerm)->orderBy('serie_id')->orderBy('volume')->get();

        return BookLightResource::collection($books);
    }

    public function byAuthor(Request $request)
    {
        $searchTerm = $request->input('search-term');
        $books = Book::whereLike(['author.name', 'author.firstname', 'author.lastname'], $searchTerm)->orderBy('serie_id')->orderBy('volume')->get();

        return AuthorLightResource::collection($books);
    }

    public function bySerie(Request $request)
    {
        $searchTerm = $request->input('search-term');
        $books = Book::whereLike(['serie.title'], $searchTerm)->orderBy('serie_id')->orderBy('volume')->get();

        return SerieLightResource::collection($books);
    }
}
