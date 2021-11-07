<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Book\BookResource;
use App\Http\Resources\BookOrSerieResource;
use App\Http\Resources\EntityResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Selectionable;
use App\Models\Serie;
use App\Query\QueryBuilderAddon;
use App\Query\QueryExporter;
use App\Query\SearchFilter;
use App\Query\Sort\AuthorRelationship;
use App\Query\Sort\LanguageRelationship;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Book
 *
 * Endpoint to get Books data.
 */
class BookController extends Controller
{
    /**
     * GET Book collection.
     *
     * <small class="badge badge-blue">WITH PAGINATION</small>
     *
     * Get all Books ordered by 'title' & Series' 'title'.
     *
     * @queryParam per-page int Entities per page, '32' by default. No-example
     * @queryParam page int The page number, '1' by default. No-example
     * @queryParam all bool To disable pagination, false by default. No-example
     * @queryParam lang filters[fr,en] To select specific lang, null by default. No-example
     *
     * @responseField title string Book's title.
     *
     * @responseFile public/assets/responses/books.index.get.json
     *
     * Examples
     * - http://localhost:8000/api/books?per-page=32&filter[has_serie]=true&filter[languages]=fr,en&filter[published]=2018-06-07,2021-11-01
     * - http://localhost:8000/api/books?per-page=32&filter[has_serie]=true&filter[title]=monde
     * - http://localhost:8000/api/books?per-page=32&filter[author_like]=bottero
     */
    public function index(Request $request)
    {
        /** @var QueryBuilder $query */
        $query = QueryBuilderAddon::for(Book::class, ['serie'])
            ->allowedFilters([
                AllowedFilter::custom('q', new SearchFilter(['title'])),
                AllowedFilter::partial('title'),
                AllowedFilter::scope('has_serie', 'whereHasSerie'),
                AllowedFilter::scope('languages', 'whereLanguagesIs'),
                AllowedFilter::scope('published', 'publishedBetween'),
                AllowedFilter::scope('author_like', 'whereAuthorIsLike'),
            ])
            ->allowedSorts([
                'id',
                'title',
                'title_sort',
                'date',
                'created_at',
                // AllowedSort::custom('author', new AuthorRelationship(), 'name'),
                // AllowedSort::custom('language', new LanguageRelationship(), 'name'),
            ])
            // ->allowedIncludes('serie', 'authors', 'media', 'serie.authors')
            ->defaultSort('title_sort')
        ;

        return QueryExporter::create($query)
            ->resource(BookLightResource::class)
            ->get()
        ;
    }

    /**
     * GET Book resource.
     *
     * Get details of Book model, find by slug of book and slug of author.
     *
     * @urlParam author_slug string required The slug of author like 'lovecraft-howard-phillips'. Example: lovecraft-howard-phillips
     * @urlParam book_slug string required The slug of book like 'les-montagnes-hallucinees-fr'. Example: les-montagnes-hallucinees-fr
     * @responseFile public/assets/responses/books.show.get.json
     */
    public function show(Request $request, Author $author, Book $book)
    {
        // if (! $book) {
        //     return response()->json([
        //         'status' => 'failed',
        //         'message' => 'No book with this author and this title.',
        //         'data' => [
        //             'route' => $request->route()->uri,
        //             'params' => [
        //                 'author' => $author->slug,
        //                 'book' => $book->slug,
        //             ],
        //         ],
        //     ], 404);
        // }

        return BookResource::make($book);
    }

    public function update(Request $request)
    {
        return Book::limit(5)->get();
    }

    /**
     * @OA\Get(
     *     path="/books/latest",
     *     tags={"books"},
     *     summary="List of latest books",
     *     description="Get list of latest books",
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Integer to choose how many books you show, default 10",
     *         required=false,
     *         example=10,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         ),
     *         style="form"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(),
     *     )
     * )
     */

    /**
     * GET Book collection latest entries.
     *
     * <small class="badge badge-blue">WITH PAGINATION</small>
     *
     * Get all Books ordered by date 'created_at'.
     *
     * @queryParam limit int To limit of entities, '10' by default. No-example
     * @queryParam per-page int Entities per page, '32' by default. No-example
     * @queryParam page int The page number, '1' by default. No-example
     * @responseFile public/assets/responses/books.latest.get.json
     */
    public function latest(Request $request)
    {
        $limit = $request->get('limit');
        $limit = $limit ? $limit : 10;
        if (! is_numeric($limit)) {
            return response()->json(
                "Invalid 'limit' query parameter, must be an int",
                400
            );
        }
        $limit = intval($limit);

        $page = $request->get('per-page') ? $request->get('per-page') : 32;
        if (! is_numeric($page)) {
            return response()->json(
                "Invalid 'per-page' query parameter, must be an int",
                400
            );
        }
        $page = intval($page);

        $books = Book::orderByDesc('created_at')->limit($limit)->get();

        return EntityResource::collection($books->paginate($page));
    }

    /**
     * GET Book collection of selection.
     *
     * Get all Books selected by team, limited to '10' results by default (no pagination).
     *
     * @responseFile public/assets/responses/books.selection.get.json
     */
    public function selection(Request $request): JsonResource
    {
        $limit = $request->get('limit');
        $limit = $limit ? $limit : 10;

        $request->relation = 'selectionable';

        $selection = Selectionable::orderBy('updated_at')->limit($limit)->get();

        return EntityResource::collection($selection);
    }

    /**
     * GET Book collection related entries.
     *
     * <small class="badge badge-blue">WITH PAGINATION</small>
     *
     * Get all Series/Books related to selected Book from Tag/Genre.
     *
     * @urlParam author_slug string required The slug of author like 'lovecraft-howard-phillips'. Example: lovecraft-howard-phillips
     * @urlParam book_slug string required The slug of book like 'les-montagnes-hallucinees-fr'. Example: les-montagnes-hallucinees-fr
     *
     * @queryParam limit int To limit of entities. No-example
     * @queryParam per-page int Entities per page, '32' by default. No-example
     * @queryParam page int The page number, '1' by default. No-example
     *
     * @responseFile public/assets/responses/books.related.get.json
     */
    public function related(Request $request, string $authorSlug, string $bookSlug)
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

        $page = $request->get('per-page') ? $request->get('per-page') : 32;
        if (! is_numeric($page)) {
            return response()->json(
                "Invalid 'per-page' query parameter, must be an int",
                400
            );
        }
        $page = intval($page);

        // get book
        $author = Author::whereSlug($authorSlug)->first();
        $book = Book::whereHas('authors', function ($query) use ($author) {
            return $query->where('author_id', '=', $author->id);
        })->whereSlug($bookSlug)->firstOrFail();
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

            return BookOrSerieResource::collection($related_books->paginate($page));
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
        $related_books = $related_books->sortBy('title_sort');

        // set limit
        if (0 !== $limit) {
            $related_books = $related_books->slice(0, $limit);
        }

        return $related_books;
    }
}
