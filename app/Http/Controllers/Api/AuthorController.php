<?php

namespace App\Http\Controllers\Api;

use App\Http\Queries\Addon\QueryOption;
use App\Http\Queries\AuthorQuery;
use App\Http\Resources\Author\AuthorLightResource;
use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Serie\SerieLightResource;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Support\MediaStream;

/**
 * @group Entity: Author
 *
 * Endpoint to get Authors data.
 */
class AuthorController extends ApiController
{
    /**
     * GET Author[].
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
        $paginate = $request->parseBoolean('paginate', true);

        return app(AuthorQuery::class)
            ->make(QueryOption::create(
                resource: AuthorLightResource::class,
                orderBy: 'lastname',
                withExport: false,
                sortAsc: true,
                withPagination: $paginate
            ))
            ->paginateOrExport()
        ;
    }

    /**
     * GET Author.
     *
     * Details for one Author, find by slug.
     */
    public function show(Author $author)
    {
        return AuthorResource::make($author);
    }

    /**
     * GET Book[] belongs to Author.
     *
     * Books list from an author, find by `slug`.
     *
     * @usesPagination
     */
    public function books(Request $request, Author $author)
    {
        if ($request->parseBoolean('standalone')) {
            $books = $author->booksAvailableStandalone();
        } else {
            $books = $author->booksAvailable();
        }

        return BookLightResource::collection($books->paginate(32));
    }

    /**
     * GET Serie[] belongs to Author.
     *
     * Series list from an author, find by `slug`.
     *
     * @usesPagination
     */
    public function series(Request $request, Author $author)
    {
        return SerieLightResource::collection($author->series()->paginate(32));
    }
}
