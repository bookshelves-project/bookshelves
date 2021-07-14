<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Spatie\Tags\Tag;
use App\Models\Serie;
use App\Models\Author;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Utils\BookshelvesTools;
use App\Http\Controllers\Controller;
use App\Http\Resources\EntityResource;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Serie\SerieLightResource;
use App\Http\Resources\Search\SearchAuthorResource;

/**
 * @group Search
 */
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
        // GET ALL PARAMS
        $onlySerieQuery = filter_var($request->input('only-serie'), FILTER_VALIDATE_BOOLEAN);
        $authorQuery = $request->author;
        $langsQuery = $request->languages;
        $tagsQuery = $request->tags;
        $query = $request->q;

        if ($query) {
            $results = collect();
            $books = Book::whereLike(['title', 'authors.name', 'serie.title'], $query)->with(['authors', 'media'])->doesntHave('serie');
            $series = Serie::whereLike(['title', 'authors.name'], $query)->with(['authors', 'media']);

            if (null !== $authorQuery) {
                $author = Author::whereSlug($authorQuery)->firstOrFail();
                $books = $books->doesntHave('serie')->whereHas('authors', function ($query) use ($author) {
                    return $query->where('author_id', '=', $author->id);
                });

                $series = $series->whereHas('authors', function ($query) use ($author) {
                    return $query->where('author_id', '=', $author->id);
                });
            }

            if (null !== $tagsQuery) {
                $tagsQuery = explode(',', $tagsQuery);
                $tags = [];
                foreach ($tagsQuery as $key => $tagSlug) {
                    $tag = Tag::where('slug->en', $tagSlug)->firstOrFail();
                    array_push($tags, $tag);
                }

                $books = $books->withAllTags($tags);
                $series = $series->withAllTags($tags);
            }

            if (null !== $langsQuery) {
                $langsQuery = explode(',', $langsQuery);
                // check if lang exist
                foreach ($langsQuery as $key => $langSlug) {
                    Language::whereSlug($langSlug)->firstOrFail();
                }

                $books = $books->whereIn('language_slug', $langsQuery);
                $series = $series->whereIn('language_slug', $langsQuery);
            }

            $books = $books->get();
            $series = $series->get();

            if ($onlySerieQuery) {
                $results = $series;
            } else {
                $results = $books->merge($series);
            }

            $results = $results->sortBy('title_sort');
            $results = EntityResource::collection($results);

            return $results;
        }

        return response()->json(['error' => 'Need to have terms query parameter'], 401);
    }
}
