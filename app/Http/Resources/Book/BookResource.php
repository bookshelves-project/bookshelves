<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Publisher\PublisherBase;
use App\Http\Resources\Tag\TagBase;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Book $resource
 */
class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...BookCollection::make($this->resource)->toArray($request),
            'contributor' => $this->resource->contributor,
            'description' => $this->resource->description,
            'released_on' => $this->resource->released_on,
            'rights' => $this->resource->rights,
            'page_count' => $this->resource->page_count,
            'maturity_rating' => $this->resource->maturity_rating,
            'isbn' => $this->resource->isbn,
            'identifiers' => IdentifierResource::make($this->resource),

            'tags' => TagBase::collection($this->resource->tags_list),
            'genres' => TagBase::collection($this->resource->genres_list),
            'publisher' => PublisherBase::make($this->resource->publisher),

            'download' => $this->resource->file_main,
            'files' => $this->resource->files_list,

            'isFavorite' => $this->resource->is_favorite,
            'reviewsCount' => $this->resource->reviews_count,
        ];
    }
}
