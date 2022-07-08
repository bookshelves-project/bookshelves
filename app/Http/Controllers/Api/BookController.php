<?php

namespace App\Http\Controllers\Api;

use App\Http\Queries\Addon\QueryOption;
use App\Http\Queries\BookQuery;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Book\BookResource;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

/**
 * @group Entity: Book
 */
class BookController extends ApiController
{
    /**
     * GET Book[].
     *
     * <small class="badge badge-blue">WITH PAGINATION</small>
     *
     * Get all Books ordered by `title` & `serie_title`.
     *
     * @usesPagination
     *
     * @queryParam filter[languages] string
     * Filter by language, `meta.slug` from languages' list, `null` by default. Example: en,fr
     *
     * @queryParam sort string
     * Sorting `slug_sort` by default, available: `title`, `slug_sort`, `date`, `created_at`, you can use `-` before parameter to reverse like `-slug_sort`. Example: slug_sort
     *
     * @responseField data object[] List of books.
     * @responseField links object Links to get other pages.
     * @responseField meta object Metadata about pagination.
     */
    public function index(Request $request)
    {
        // Examples
        // - http://localhost:8000/api/books?size=32&filter[has_serie]=true&filter[languages]=fr,en&filter[published]=2018-06-07,2021-11-01
        // - http://localhost:8000/api/books?size=32&filter[has_serie]=true&filter[title]=monde
        // - http://localhost:8000/api/books?size=32&filter[author_like]=bottero

        $this->getLang($request);

        return app(BookQuery::class)
            ->make(QueryOption::create(
                request: $request,
                resource: BookLightResource::class,
                orderBy: 'slug_sort',
                withExport: false,
                sortAsc: true,
                full: $this->getFull($request),
            ))
            ->paginateOrExport();
    }

    /**
     * GET Book.
     */
    public function show(Request $request, Author $author, Book $book)
    {
        $this->getLang($request);

        return BookResource::make($book);
    }
}
