<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\BookOrSerieResource;
use App\Http\Resources\Serie\SerieLightResource;
use App\Http\Resources\Serie\SerieResource;
use App\Models\Author;
use App\Models\Serie;
use App\Query\QueryBuilderAddon;
use App\Query\QueryExporter;
use App\Query\SearchFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Entity: Serie
 *
 * Endpoint to get Series data.
 */
class SerieController extends Controller
{
    /**
     * GET Serie collection.
     *
     * <small class="badge badge-blue">WITH PAGINATION</small>
     *
     * Get all Series ordered by 'title'.
     *
     * @queryParam perPage int Entities per page, '32' by default. No-example
     * @queryParam page int The page number, '1' by default. No-example
     * @queryParam all bool To disable pagination, false by default. No-example
     * @queryParam lang filters[fr,en] To select specific lang, null by default. No-example
     *
     * @responseFile public/assets/responses/series.index.get.json
     */
    public function index(Request $request)
    {
        /** @var QueryBuilder $query */
        $query = QueryBuilderAddon::for(Serie::class, with: ['authors', 'media'], withCount: ['books'])
            ->allowedFilters([
                AllowedFilter::custom('q', new SearchFilter(['title'])),
                AllowedFilter::partial('title'),
                AllowedFilter::scope('languages', 'whereLanguagesIs'),
            ])
            ->allowedSorts([
                'id',
                'title',
                'title_sort',
                'created_at',
            ])
            ->defaultSort('title_sort')
        ;

        return QueryExporter::create($query)
            ->resource(SerieLightResource::class)
            ->get()
        ;
    }

    // /**
    //  * GET Serie resource.
    //  *
    //  * Get details of Serie model, find by slug of serie and slug of author.
    //  *
    //  * @urlParam author_slug string required The slug of author like 'lovecraft-howard-phillips'. Example: lovecraft-howard-phillips
    //  * @urlParam serie_slug string required The slug of serie like 'les-montagnes-hallucinees-fr'. Example: les-montagnes-hallucinees-fr
    //  *
    //  * @responseFile public/assets/responses/series.show.get.json
    //  */
    public function show(string $author, string $serie)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $serie = Serie::whereHas('authors', function ($query) use ($author) {
            return $query->where('author_id', '=', $author->id);
        })->whereSlug($serie)->withCount('books')->first();

        return SerieResource::make($serie);
    }

    /**
     * GET Book collection of Serie.
     *
     * Books list from one Serie, find by slug.
     *
     * @queryParam perPage int Entities per page, '32' by default. No-example
     * @queryParam page int The page number, '1' by default. No-example
     * @urlParam author_slug string required The slug of author like 'lovecraft-howard-phillips'. Example: lovecraft-howard-phillips
     * @urlParam serie_slug string required The slug of serie like 'les-montagnes-hallucinees-fr'. Example: les-montagnes-hallucinees-fr
     *
     * @responseFile public/assets/responses/series.books.get.json
     */
    public function books(Request $request, string $author_slug, string $serie_slug)
    {
        $page = $request->get('perPage');
        $page = $page ? $page : 32;
        if (! is_numeric($page)) {
            return response()->json(
                "Invalid 'perPage' query parameter, must be an int",
                400
            );
        }
        $page = intval($page);

        Author::whereSlug($author_slug)->firstOrFail();
        $serie = Serie::whereSlug($serie_slug)->with(['books', 'books.media', 'books.authors', 'books.serie', 'books.language'])->firstOrFail();
        if ($author_slug === $serie->meta_author) {
            $books = $serie->books;

            return BookLightResource::collection($books->paginate($page));
        }

        return abort(404);
    }

    /**
     * GET Book collection of Serie (from volume).
     *
     * Books list from one Serie, find by slug from volume and limited to 10 results.
     *
     * @urlParam author_slug string required The slug of author like '1'. Example: 1
     * @urlParam author_slug string required The slug of author like 'lovecraft-howard-phillips'. Example: lovecraft-howard-phillips
     * @urlParam serie_slug string required The slug of serie like 'les-montagnes-hallucinees-fr'. Example: les-montagnes-hallucinees-fr
     *
     * @responseFile public/assets/responses/series.current.get.json
     */
    public function current(Request $request, string $volume, string $author, string $serie)
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
}
