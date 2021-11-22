<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Author\AuthorLightResource;
use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Serie\SerieLightResource;
use App\Models\Author;
use App\Query\QueryBuilderAddon;
use App\Query\QueryExporter;
use App\Query\SearchFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Author
 *
 * Endpoint to get Authors data.
 */
class AuthorController extends Controller
{
    /**
     * GET Author collection.
     *
     * <small class="badge badge-blue">WITH PAGINATION</small>
     *
     * You can get all Authors with alphabetic order on lastname with pagination.
     *
     * @queryParam per-page int Entities per page, '32' by default. No-example
     * @queryParam page int The page number, '1' by default. No-example
     * @responseFile public/assets/responses/authors.index.get.json
     */
    public function index(Request $request)
    {
        /** @var QueryBuilder $query */
        $query = QueryBuilderAddon::for(Author::class, with: ['media'], withCount: ['books'])
            ->allowedFilters([
                AllowedFilter::custom('q', new SearchFilter(['name'])),
                AllowedFilter::partial('firstname'),
                AllowedFilter::partial('lastname'),
            ])
            ->allowedSorts([
                'id',
                'firstname',
                'lastname',
                'created_at',
            ])
            ->defaultSort('lastname')
        ;

        return QueryExporter::create($query)
            ->resource(AuthorLightResource::class)
            ->get()
        ;
    }

    /**
     * GET Author resource.
     *
     * Details for one Author, find by slug.
     *
     * @urlParam slug string required The slug of author like 'lovecraft-howard-phillips'. Example: lovecraft-howard-phillips
     * @responseFile public/assets/responses/authors.show.get.json
     */
    public function show(Author $author)
    {
        try {
            return AuthorResource::make($author);
        } catch (\Throwable $th) {
            return response()->json(['failed' => 'No result for '.$author], 404);
        }
    }

    /**
     * GET Book collection of Author.
     *
     * Books list from one author, find by slug.
     *
     * @queryParam per-page int Entities per page, '32' by default. No-example
     * @queryParam page int The page number, '1' by default. No-example
     * @urlParam author_slug string required The slug of author like 'lovecraft-howard-phillips'. Example: lovecraft-howard-phillips
     *
     * @responseFile public/assets/responses/authors.books.get.json
     */
    public function books(Request $request, string $author)
    {
        $page = $request->get('per-page');
        $page = $page ? $page : 32;
        if (! is_numeric($page)) {
            return response()->json(
                "Invalid 'per-page' query parameter, must be an int",
                400
            );
        }
        $page = intval($page);

        $standalone = $request->get('standalone') ? filter_var($request->get('standalone'), FILTER_VALIDATE_BOOLEAN) : false;

        if ($standalone) {
            $author = Author::whereSlug($author)->with(['books.media', 'books.authors', 'books.serie', 'books.language'])->with(['books' => function ($book) {
                return $book->whereDoesntHave('serie');
            }])->firstOrFail();
        } else {
            $author = Author::whereSlug($author)->with(['books.media', 'books.authors', 'books.serie', 'books.language'])->firstOrFail();
        }

        return BookLightResource::collection($author->books->paginate($page));
    }

    /**
     * GET Serie collection of Author.
     *
     * Series list from one author, find by slug.
     *
     * @queryParam per-page int Entities per page, '32' by default. No-example
     * @queryParam page int The page number, '1' by default. No-example
     * @urlParam author_slug string required The slug of author like 'lovecraft-howard-phillips'. Example: lovecraft-howard-phillips
     * @responseFile public/assets/responses/authors.series.get.json
     */
    public function series(Request $request, string $author)
    {
        $page = $request->get('per-page');
        $page = $page ? $page : 32;
        if (! is_numeric($page)) {
            return response()->json(
                "Invalid 'per-page' query parameter, must be an int",
                400
            );
        }
        $page = intval($page);

        $author = Author::whereSlug($author)->with(['series' => function ($query) {
            $query->withCount('books');
        }, 'series.media', 'series.authors', 'series.language', 'series.books'])->firstOrFail();

        return SerieLightResource::collection($author->series->paginate($page));
    }
}
