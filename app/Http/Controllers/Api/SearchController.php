<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightestResource;
use App\Http\Resources\EntityResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
use App\Models\Serie;
use App\Utils\BookshelvesTools;
use App\Utils\QueryExporter;
use App\Utils\SearchFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
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
        // $query = QueryBuilder::for(Book::class)
        //     ->allowedFilters([
        //         // 'serie.title',
        //         // http://localhost:8000/api/search?filter[q]=ewilan
        //         // AllowedFilter::custom('q', new SearchFilter(['title'])),
        //         // http://localhost:8000/api/users?filter[title]=ewilan
        //         AllowedFilter::partial('title'),
        //         AllowedFilter::partial('serie.title'),
        //         // AllowedFilter::scope('serie_title', 'whereSerieTitleIs'),
        //         // AllowedFilter::partial('first_name'),
        //         // AllowedFilter::partial('last_name'),
        //         // AllowedFilter::exact('id'),
        //         // AllowedFilter::exact('role'),
        //         // AllowedFilter::exact('active'),
        //         // AllowedFilter::exact('regional_service_slug'),
        //         // AllowedFilter::exact('role'),
        //     ])
        //     // http://localhost:8000/api/users?sort=title
        //     ->allowedSorts(['id', 'title'])
        //     ->paginate(32)
        //     // ->limit(30)
        // ;

        // $exporter = new QueryExporter($query);
        // $resource = $exporter->resource(BookLightestResource::class);

        // return (new QueryExporter($query))
        //     ->resource(BookResource::class)
        // ;

        // return $resource->get();

        $q = $request->input('q');
        if ($q) {
            if ('collection' === config('scout.driver')) {
                $collection = BookshelvesTools::searchGlobal($q);
            } else {
                $books = Book::search($q)->get();
                $authors = Author::search($q)->get();
                $series = Serie::search($q)->get();

                $authors = EntityResource::collection($authors);
                $series = EntityResource::collection($series);
                $books = EntityResource::collection($books);

                $collection = collect([]);
                $collection = $collection->merge($authors);
                $collection = $collection->merge($series);
                $collection = $collection->merge($books);
            }

            return response()->json([
                'data' => $collection,
            ]);
        }

        return response()->json(['error' => 'Need to have terms `q` parameter'], 401);
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
