<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Author\AuthorUltraLightResource;
use App\Models\Book;
use App\Utils\BookshelvesTools;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Book $resource
 */
class BookUltraLightResource extends JsonResource
{
    /**
     * Transform the Book into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @mixin Book
     */
    public function toArray($request): array
    {
        return [
            'title' => $this->resource->title,
            'meta' => [
                'entity' => $this->resource->getClassName(),
                'slug' => $this->resource->slug,
                'author' => $this->resource->meta_author,
                'show' => $this->resource->show_link,
                'related' => $this->resource->show_related_link,
            ],
            'authors' => AuthorUltraLightResource::collection($this->resource->authors),
            'summary' => BookshelvesTools::stringLimit($this->resource->description, 140),
            'language' => $this->resource->language?->slug,
            'publishDate' => $this->resource->date,
            'cover' => [
                'thumbnail' => $this->resource->cover_thumbnail,
                'simple' => $this->resource->cover_simple,
                'color' => $this->resource->cover_color,
            ],
            'volume' => $this->resource->volume,
        ];
    }
}
