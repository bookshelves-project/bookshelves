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
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @group Entity: Book
 */
class BookController extends ApiController
{
    /**
     * GET List books.
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
     * GET Book details.
     */
    public function show(Author $author, Book $book)
    {
        return BookResource::make($book);
    }

    public function update(Request $request)
    {
        return Book::limit(5)->get();
    }

    /**
     * GET Book collection latest entries.
     *
     * <small class="badge badge-blue">WITH PAGINATION</small>
     *
     * Get all Books ordered by date 'created_at'.
     *
     * @usesPagination
     *
     * @queryParam limit int To limit of entities, '10' by default. No-example
     */
    public function latest(Request $request)
    {
        $books = Book::orderByDesc('updated_at')
            ->limit(10)
            ->get()
        ;

        return EntityResource::collection($books);
    }

    /**
     * GET Book collection of selection.
     *
     * Get all Books selected by team, limited to '10' results by default (no pagination).
     */
    public function selection(Request $request): JsonResource
    {
        $request->relation = 'selectionable';

        $selection = Selectionable::orderBy('updated_at')
            ->limit(10)
            ->get()
        ;

        return EntityResource::collection($selection);
    }

    /**
     * GET Book collection related entries.
     *
     * <small class="badge badge-blue">WITH PAGINATION</small>
     *
     * Get all Series/Books related to selected Book from Tag/Genre.
     *
     * @usesPagination
     *
     * @queryParam limit int To limit of entities. No-example
     */
    public function related(Request $request, Author $author, Book $book)
    {
        $limit = $request->get('limit');
        $limit = $limit ? $limit : 0;
        if (! is_numeric($limit)) {
            return response()->json(
                "Invalid 'limit' query parameter, must be an int",
                400
            );
        }
        $limit = intval($limit);

        $page = $request->get('perPage') ? $request->get('perPage') : 32;
        if (! is_numeric($page)) {
            return response()->json(
                "Invalid 'perPage' query parameter, must be an int",
                400
            );
        }
        $page = intval($page);

        // get book
        // $author = Author::whereSlug($authorSlug)->first();
        // $book = Book::whereHas('authors', function ($query) use ($author) {
        //     return $query->where('author_id', '=', $author_slug->id);
        // })->whereSlug($bookSlug)->firstOrFail();
        // get book tags
        $tags = $book->tags;

        // if tags
        if (sizeof($tags) >= 1) {
            // get related books by tags, same lang, limited to 10 results
            $related_books = Book::withAllTags($tags)->whereLanguageSlug($book->language_slug)->get();
            $related_books = $this->filterRelatedBooks($book, $related_books, $limit);

            if ($related_books->count() <= 1) {
                $related_books = Book::withAnyTags($tags)->whereLanguageSlug($book->language_slug)->get();
                $related_books = $this->filterRelatedBooks($book, $related_books, $limit);
            }

            return BookOrSerieResource::collection(PaginationHelper::paginate($related_books, $page));
        }

        return response()->json(
            'No tags',
            400
        );
    }

    public function filterRelatedBooks(Book $book, Collection $related_books, int $limit = 0): Collection
    {
        // get serie of current book
        $serie_books = Serie::whereSlug($book->serie?->slug)->first();
        // get books of this serie
        $serie_books = $serie_books?->books;

        // if serie exist
        if ($serie_books) {
            // remove all books from this serie
            $filtered = $related_books->filter(function ($book) use ($serie_books) {
                foreach ($serie_books as $serie_book) {
                    if ($book->serie) {
                        return $book->serie->slug != $serie_book->serie->slug;
                    }
                }
            });
            $related_books = $filtered;
        }
        // remove current book
        $related_books = $related_books->filter(function ($related_book) use ($book) {
            return $related_book->slug != $book->slug;
        });

        // get series of related
        $series_list = collect();
        foreach ($related_books as $key => $book) {
            if ($book->serie) {
                $series_list->add($book->serie);
            }
        }
        // remove all books of series
        $related_books = $related_books->filter(function ($book) {
            return null === $book->serie;
        });

        // unique on series
        $series_list = $series_list->unique();

        // merge books and series
        $related_books = $related_books->merge($series_list);

        // sort entities
        $related_books = $related_books->sortBy('slug_sort');

        // set limit
        if (0 !== $limit) {
            $related_books = $related_books->slice(0, $limit);
        }

        return $related_books;
    }

    /**
     * GET Download EPUB.
     *
     * <small class="badge badge-green">Content-Type application/epub+zip</small>
     *
     * Download Book EPUB, find by slug of book and slug of author.
     *
     * @header Content-Type application/epub+zip
     */
    public function download(Author $author, Book $book)
    {
        $format = BookFormatEnum::epub->name;
        $media = $book->files[$format];

        return response()->download($media->getPath(), $media->file_name);
    }
}
