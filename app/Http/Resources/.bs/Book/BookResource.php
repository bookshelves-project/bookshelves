<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Publisher\PublisherRelationResource;
use App\Http\Resources\Tag\TagRelationResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Book $resource
 */
class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            ...BookCollectionResource::make($this->resource)->toArray($request),
            'contributor' => $this->resource->contributor,
            'description' => $this->resource->description,
            'released_on' => $this->resource->released_on,
            'rights' => $this->resource->rights,
            'page_count' => $this->resource->page_count,
            'maturity_rating' => $this->resource->maturity_rating,
            'isbn' => $this->resource->isbn,
            'identifiers' => BookEntityIdentifierResource::make($this->resource),

            'tags' => TagRelationResource::collection($this->resource->tags_list),
            'genres' => TagRelationResource::collection($this->resource->genres_list),
            'publisher' => PublisherRelationResource::make($this->resource->publisher),

            'download' => $this->resource->file_main,
            'files' => $this->resource->files_list,

            'isFavorite' => $this->resource->is_favorite,
            'reviewsCount' => $this->resource->reviews_count,
        ];
    }
}
