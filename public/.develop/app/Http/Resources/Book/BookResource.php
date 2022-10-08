<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Author\AuthorUltraLightResource;
use App\Http\Resources\GoogleBookResource;
use App\Http\Resources\Publisher\PublisherLightResource;
use App\Http\Resources\Serie\SerieUltraLightResource;
use App\Http\Resources\SpatieMediaResource;
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
     * @param  \Illuminate\Http\Request  $request
     * @mixin Book
     */
    public function toArray($request): array
    {
        return [
            ...BookLightResource::make($this->resource)->toArray($request),
            'meta' => [
                'entity' => $this->resource->entity,
                'slug' => $this->resource->slug,
                'author' => $this->resource->meta_author,
                'show' => $this->resource->show_link,
                'related' => $this->resource->related_link,
                'reviews' => $this->resource->reviews_link,
            ],
            'serie' => SerieUltraLightResource::make($this->resource->serie),
            'authors' => AuthorUltraLightResource::collection($this->resource->authors),
            'media' => SpatieMediaResource::make($this->resource->media_primary),
            'media_social' => $this->resource->cover_simple,
            'description' => $this->resource->description,
            'identifier' => BookIdentifierResource::make($this->resource),
            'pageCount' => $this->resource->page_count,
            'maturityRating' => $this->resource->maturity_rating,
            'publisher' => PublisherLightResource::make($this->resource->publisher),
            'tags' => TagLightResource::collection($this->resource->tags_list),
            'genres' => TagLightResource::collection($this->resource->genres_list),
            'download' => $this->resource->file_main,
            'files' => $this->resource->files_list,
            'googleBook' => GoogleBookResource::make($this->resource->googleBook),
            'isFavorite' => $this->resource->is_favorite,
            'reviewsCount' => $this->resource->reviews_count,
        ];
    }
}
