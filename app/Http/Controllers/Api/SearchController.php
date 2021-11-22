<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EntityResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
use App\Models\Serie;
use App\Services\SearchEngineService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\Tags\Tag;

/**
 * @group Search
 */
class SearchController extends Controller
{
    /**
     * GET Entities collection.
     *
     * Get Authors/Series/Books entities ordered by entity and lastname / title. Query can be series' title, book's title, author's firstname or lastname.
     *
     * @queryParam q string required Query search, null by default. Example: lovecraft
     *
     * @responseFile public/assets/responses/search.index.get.json
     */
    public function index(Request $request)
    {
        $q = $request->input('q');
        $types = $request->input('types');
        if ($types) {
            $types = explode(',', $types);
        }

        if ($q) {
            $engine = SearchEngineService::create($q, $types);

            return response()->json([
                'data' => [
                    'count' => $engine->results_count,
                    'type' => $engine->search_type,
                    'relevant' => [
                        'authors' => $engine->authors_relevant,
                        'series' => $engine->series_relevant,
                        'books' => $engine->books_relevant,
                    ],
                    'other' => [
                        'authors' => $engine->authors_other,
                        'series' => $engine->series_other,
                        'books' => $engine->books_other,
                    ],
                ],
            ]);
        }

        // return response()->json(['error' => 'Need to have terms `q` parameter'], 401);
    }

    /**
     * GET Entities collection (advanced).
     *
     * Get Authors/Series/Books entities ordered by entity and lastname / title.
     *
     * @queryParam q string required Query search, null by default. Example: lovecraft
     *
     * @responseFile public/assets/responses/search.index.get.json
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

            return EntityResource::collection($results);
        }

        return response()->json(['error' => 'Need to have terms query parameter'], 401);
    }
}
