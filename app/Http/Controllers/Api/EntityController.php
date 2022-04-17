<?php

namespace App\Http\Controllers\Api;

use App\Engines\SearchEngine;
use App\Helpers\PaginationHelper;
use App\Http\Resources\EntityResource;
use App\Http\Resources\Review\ReviewResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Review;
use App\Models\Selectionable;
use App\Services\EntityService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Entities
 *
 * Endpoint about data from main entities.
 */
class EntityController extends ApiController
{
    /**
     * GET Entity[] latest entries.
     *
     * Get all Books ordered by date `updated_at`, limited to `10` results (no pagination).
     */
    public function latest(Request $request): JsonResource
    {
        $books = Book::orderByDesc('updated_at')
            ->limit(10)
            ->get()
        ;

        return EntityResource::collection($books);
    }

    /**
     * GET Entity[] from Selectionable.
     *
     * Get all entities `selected`, limited to `10` results (no pagination).
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
        if ($book->tags->count() >= 1) {
            $related_books = EntityService::filterRelated($book);

            if ($related_books->isNotEmpty()) {
                return EntityResource::collection(PaginationHelper::paginate($related_books));
            }
        }

        return response()->json(
            'No tags or no books related',
            400
        );
    }

    /**
     * GET Entity Review[].
     */
    public function reviews(Request $request, string $entity, int $id)
    {
        $this->getLang($request);

        $reviews = Review::whereReviewableType($this->getEntity($entity))
            ->whereReviewableId($id)
            ->paginate($this->getPaginationSize($request, 5))
        ;

        return ReviewResource::collection($reviews);
    }

    /**
     * GET Search.
     *
     * Search full-text into authors, books & series.
     */
    public function search(Request $request)
    {
        $q = $request->input('q');
        $types = $request->input('types');
        if ($types) {
            $types = explode(',', $types);
        }

        if ($q) {
            $engine = SearchEngine::create($q, true, $types);

            return response()->json([
                'data' => [
                    'count' => $engine->count,
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

        return response()->json([
            'message' => 'You have to use `q` as query param to search.',
        ], 404);
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function searchAdvanced(Request $request)
    {
        // GET ALL PARAMS
        // $onlySerieQuery = filter_var($request->input('only-serie'), FILTER_VALIDATE_BOOLEAN);
        // $authorQuery = $request->author;
        // $langsQuery = $request->languages;
        // $tagsQuery = $request->tags;
        // $query = $request->q;

        // if ($query) {
        //     $results = collect();
        //     $books = Book::whereLike(['title', 'authors.name', 'serie.title'], $query)->with(['authors', 'media'])->doesntHave('serie');
        //     $series = Serie::whereLike(['title', 'authors.name'], $query)->with(['authors', 'media']);

        //     if (null !== $authorQuery) {
        //         $author = Author::whereSlug($authorQuery)->firstOrFail();
        //         $books = $books->doesntHave('serie')->whereHas('authors', function ($query) use ($author) {
        //             return $query->where('author_id', '=', $author->id);
        //         });

        //         $series = $series->whereHas('authors', function ($query) use ($author) {
        //             return $query->where('author_id', '=', $author->id);
        //         });
        //     }

        //     if (null !== $tagsQuery) {
        //         $tagsQuery = explode(',', $tagsQuery);
        //         $tags = [];
        //         foreach ($tagsQuery as $key => $tagSlug) {
        //             $tag = Tag::where('slug->en', $tagSlug)->firstOrFail();
        //             array_push($tags, $tag);
        //         }

        //         $books = $books->withAllTags($tags);
        //         $series = $series->withAllTags($tags);
        //     }

        //     if (null !== $langsQuery) {
        //         $langsQuery = explode(',', $langsQuery);
        //         // check if lang exist
        //         foreach ($langsQuery as $key => $langSlug) {
        //             Language::whereSlug($langSlug)->firstOrFail();
        //         }

        //         $books = $books->whereIn('language_slug', $langsQuery);
        //         $series = $series->whereIn('language_slug', $langsQuery);
        //     }

        //     $books = $books->get();
        //     $series = $series->get();

        //     if ($onlySerieQuery) {
        //         $results = $series;
        //     } else {
        //         $results = $books->merge($series);
        //     }

        //     $results = $results->sortBy('slug_sort');

        //     return EntityResource::collection($results);
        // }

        // return response()->json(['error' => 'Need to have terms query parameter'], 401);
    }
}
