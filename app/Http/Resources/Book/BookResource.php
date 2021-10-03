<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Author\AuthorUltraLightResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\GoogleBookResource;
use App\Http\Resources\IdentifierResource;
use App\Http\Resources\Publisher\PublisherLightResource;
use App\Http\Resources\Serie\SerieLightResource;
use App\Http\Resources\Tag\TagLightResource;
use App\Models\Book;
use App\Utils\BookshelvesTools;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Book $resource
 */
class BookResource extends JsonResource
{
    /**
     * Transform the Book into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @mixin Book
     */
    public function toArray($request): array
    {
        // $this->resource->title;

        /** @var Book $book */
        $book = $this;

        $resource = BookLightResource::make($book)->toArray($request);

        return array_merge($resource, [
            'serie' => SerieLightResource::make($book->serie),
            'authors' => AuthorUltraLightResource::collection($book->authors),
            'cover' => [
                'thumbnail' => $book->cover_thumbnail,
                'og' => $book->cover_og,
                'simple' => $book->cover_simple,
                'original' => $book->cover_original,
                'color' => $this->resource->cover_color,
            ],
            'description' => $book->description,
            'identifier' => IdentifierResource::make($book->identifier),
            'pageCount' => $book->page_count,
            'maturityRating' => $book->maturity_rating,
            'publisher' => PublisherLightResource::make($this->resource->publisher),
            'tags' => TagLightResource::collection($book->tags_list),
            'genres' => TagLightResource::collection($book->genres_list),
            'epub' => [
                'name' => $book->getMedia('epubs')->first()->file_name,
                'size' => BookshelvesTools::humanFilesize($book->getMedia('epubs')->first()->size),
                'download' => $book->download_link,
            ],
            'webreader' => $book->webreader_link,
            'googleBook' => GoogleBookResource::make($book->googleBook),
            'isFavorite' => $book->is_favorite,
            'comments' => CommentResource::collection($book->comments),
        ]);
    }
}
