<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Author\AuthorUltraLightResource;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\GoogleBookResource;
use App\Http\Resources\MediaResource;
use App\Http\Resources\Publisher\PublisherLightResource;
use App\Http\Resources\Serie\SerieLightResource;
use App\Http\Resources\Tag\TagLightResource;
use App\Models\Book;
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
        $resource = (array) BookLightResource::make($this->resource)->toArray($request);

        return array_merge($resource, [
            'serie' => SerieLightResource::make($this->resource->serie),
            'authors' => AuthorUltraLightResource::collection($this->resource->authors),
            'cover' => [
                'thumbnail' => $this->resource->cover_thumbnail,
                'og' => $this->resource->cover_og,
                'simple' => $this->resource->cover_simple,
                'original' => $this->resource->cover_original,
                'color' => $this->resource->cover_color,
            ],
            'description' => $this->resource->description,
            'identifier' => BookIdentifierResource::make($this->resource),
            'pageCount' => $this->resource->page_count,
            'maturityRating' => $this->resource->maturity_rating,
            'publisher' => PublisherLightResource::make($this->resource->publisher),
            'tags' => TagLightResource::collection($this->resource->tags_list),
            'genres' => TagLightResource::collection($this->resource->genres_list),
            'epub' => MediaResource::make($this->resource->epub),
            'webreader' => $this->resource->webreader_link,
            'googleBook' => GoogleBookResource::make($this->resource->googleBook),
            'isFavorite' => $this->resource->is_favorite,
            'comments' => CommentResource::collection($this->resource->comments),
        ]);
    }
}
