<?php

namespace App\Http\Controllers\Api;

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
class AuthorController extends ApiController
{
    /**
     * GET List authors.
     *
     * <small class="badge badge-blue">WITH PAGINATION</small>
     *
     * Get all authors ordered by `title` & `serie_title`.
     *
     * @usesPagination
     *
     * @responseField data object[] List of authors.
     * @responseField links object Links to get other pages.
     * @responseField meta object Metadata about pagination.
     */
    public function index(Request $request)
    {
        /** @var QueryBuilder $query */
        $query = QueryBuilderAddon::for(Author::class, with: ['media'], withCount: ['books', 'series'])
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
     * @urlParam author string required
     */
    public function show(Author $author)
    {
        return AuthorResource::make($author);
    }

    /**
     * GET Books list of an author.
     *
     * Books list from an author, find by `slug`.
     *
     * @usesPagination
     */
    public function books(Request $request, Author $author)
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

        $standalone = $request->get('standalone') ? filter_var($request->get('standalone'), FILTER_VALIDATE_BOOLEAN) : false;

        // if ($standalone) {
        //     $author = Author::whereSlug($author)->with(['books.media', 'books.authors', 'books.serie', 'books.language'])->with(['books' => function ($book) {
        //         return $book->whereDoesntHave('serie');
        //     }])->firstOrFail();
        // } else {
        //     $author = Author::whereSlug($author)->with(['books.media', 'books.authors', 'books.serie', 'books.language'])->firstOrFail();
        // }

        return BookLightResource::collection($author->books()->paginate($page));
    }

    /**
     * GET Series list of an author.
     *
     * Series list from an author, find by `slug`.
     *
     * @usesPagination
     */
    public function series(Request $request, Author $author)
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

        // $author = Author::whereSlug($author)->with(['series' => function ($query) {
        //     $query->withCount('books');
        // }, 'series.media', 'series.authors', 'series.language', 'series.books'])->firstOrFail();

        return SerieLightResource::collection($author->series()->paginate($page));
    }
}
