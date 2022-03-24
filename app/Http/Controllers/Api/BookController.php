<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookFormatEnum;
use App\Helpers\PaginationHelper;
use App\Http\Queries\Addon\QueryOption;
use App\Http\Queries\BookQuery;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Book\BookResource;
use App\Http\Resources\BookOrSerieResource;
use App\Http\Resources\EntityResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Selectionable;
use App\Models\Serie;
use App\Services\EntityService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

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
        // - http://localhost:8000/api/books?perPage=32&filter[has_serie]=true&filter[languages]=fr,en&filter[published]=2018-06-07,2021-11-01
        // - http://localhost:8000/api/books?perPage=32&filter[has_serie]=true&filter[title]=monde
        // - http://localhost:8000/api/books?perPage=32&filter[author_like]=bottero

        $paginate = $request->parseBoolean('paginate', true);

        return app(BookQuery::class)
            ->make(QueryOption::create(
                resource: BookLightResource::class,
                orderBy: 'slug_sort',
                withExport: false,
                sortAsc: true,
                withPagination: $paginate,
            ))
            ->paginateOrExport()
        ;
    }

    /**
     * GET Book.
     */
    public function show(Author $author, Book $book)
    {
        return BookResource::make($book);
    }

    /**
     * GET Entity[] related to Book.
     *
     * <small class="badge badge-blue">WITH PAGINATION</small>
     *
     * Get all Series/Books related to selected Book from Tag.
     *
     * @usesPagination
     */
    public function related(Request $request, Author $author, Book $book)
    {
        $page = $this->getPerPages($request);

        if ($book->tags->count() >= 1) {
            $related_books = EntityService::filterRelated($book);

            if ($related_books->isNotEmpty()) {
                return BookOrSerieResource::collection(PaginationHelper::paginate($related_books, $page));
            }
        }

        return response()->json(
            'No tags or no books related',
            400
        );
    }

    /**
     * GET Download.
     *
     * <small class="badge badge-green">Content-Type application/epub+zip</small>
     *
     * Download Book EPUB, find by slug of book and slug of author.
     *
     * @header Content-Type application/epub+zip
     */
    public function download(Author $author, Book $book, string $format = 'epub')
    {
        $format = BookFormatEnum::tryFrom($format)->name;
        $media = $book->files[$format];
        if (null === $media) {
            foreach ($book->files as $value) {
                if (null !== $value) {
                    $media = $value;
                }
            }
        }

        return response()->download($media->getPath(), $media->file_name);
    }
}
