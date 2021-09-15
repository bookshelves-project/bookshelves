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

/**
 * @group Search
 */
class SearchController extends Controller
{
    /**
    * GET Entities collection
    *
    * Get Authors/Series/Books entities ordered by entity and lastname / title. Query can be series' title, book's title, author's firstname or lastname.
    *
    * @queryParam q string required Query search, null by default. Example: lovecraft
    *
    * @responseFile public/storage/responses/search.index.get.json
    */
    public function index(Request $request)
    {
        // - with pagination
        $searchTermRaw = $request->input('q');
        if ($searchTermRaw) {
            if (config('scout.driver' === 'collection')) {
                $collection = BookshelvesTools::searchGlobal($searchTermRaw);
            } else {
                $books = Book::search($searchTermRaw)->get();
                $authors = Author::search($searchTermRaw)->get();
                $series = Serie::search($searchTermRaw)->get();

                $authors = EntityResource::collection($authors);
                $series = EntityResource::collection($series);
                $books = EntityResource::collection($books);
            
                $collection = collect([]);
                $collection = $collection->merge($authors);
                $collection = $collection->merge($series);
                $collection = $collection->merge($books);
            }
            // $collection->splice(50);
            // dd($collection->count());

            return response()->json([
                'data' => $collection,
            ]);
        }

        return response()->json(['error' => 'Need to have terms query parameter'], 401);
    }

    /**
    * GET Entities collection (advanced)
    *
    * Get Authors/Series/Books entities ordered by entity and lastname / title.
    *
    * @queryParam q string required Query search, null by default. Example: lovecraft
    *
    * @responseFile public/storage/responses/search.index.get.json
    */
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
