<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Utils\BookshelvesTools;
use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Serie\SerieLightResource;
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
     *         example="lovecraft",
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

    public function books(Request $request)
    {
        $searchTerm = $request->input('q');
        $books = Book::whereLike(['title'], $searchTerm)->orderBy('serie_id')->orderBy('volume')->get();

        return BookLightResource::collection($books);
    }

    public function authors(Request $request)
    {
        $searchTerm = $request->input('q');
        // $books = Book::whereLike(['author.name', 'author.firstname', 'author.lastname'], $searchTerm)->orderBy('serie_id')->orderBy('volume')->get();
        $authors = Author::whereLike(['name', 'firstname', 'lastname'], $searchTerm)->get();

        return SearchAuthorResource::collection($authors);
    }

    public function series(Request $request)
    {
        $searchTerm = $request->input('q');
        $books = Book::whereLike(['serie.title'], $searchTerm)->orderBy('serie_id')->orderBy('volume')->get();

        return SerieLightResource::collection($books);
    }

    public function advanced(Request $request)
    {
        // http://localhost:8000/api/search/advanced?q=ewilan&author=bottero-pierre&serie=true&languages=french,english&tags=fantasy,jeunesse

        // GET ALL PARAMS
        // $onlySerieQuery = filter_var($request->serie, FILTER_VALIDATE_BOOLEAN);
        // dump($onlySerieQuery);
        // $authorQuery = $request->author;
        // dump($authorQuery);
        // $langsQuery = $request->languages;
        // dump($langsQuery);
        // $tagsQuery = $request->tags;
        // dump($tagsQuery);
        // $query = $request->q;
        // dump($query);

        // $author = Author::whereSlug($authorQuery)->first();

        // $collection = BookshelvesTools::searchGlobal($query);
        // dump($collection);

        // $collectionSearch = [];
        // foreach ($collection as $key => $value) {
        //     if ($value['author'] === $author->name) {
        //         array_push($collectionSearch, $value);
        //     }
        // }
        // dump($collectionSearch);

        $searchTermRaw = $request->input('q');
        if ($searchTermRaw) {
            // $collection = BookshelvesTools::searchGlobal($searchTermRaw);
            $collection = BookshelvesTools::searchGlobalIdentifier($searchTermRaw);

            return response()->json([
                'data' => $collection,
            ]);
        }

        return response()->json(['error' => 'Need to have terms query parameter'], 401);
    }
}
