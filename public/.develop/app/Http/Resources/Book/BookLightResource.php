<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Serie\SerieUltraLightResource;
use App\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Book $resource
 */
class BookLightResource extends JsonResource
{
    /**
     * Transform the Book into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @mixin Book
     */
    public function toArray($request)
    {
        return array_merge(BookUltraLightResource::make($this->resource)->toArray($request), [
            // 'serie' => SerieUltraLightResource::make($this->resource->serie),
            'serie' => $this->resource->serie ? [
                'title' => $this->resource->serie->title,
                // 'type' => $this->resource->type->i18n(),
                'meta' => [
                    'entity' => $this->resource->serie->entity,
                    'slug' => $this->resource->serie->slug,
                    'author' => $this->resource->serie->meta_author,
                    'show' => $this->resource->serie->show_link,
                ],
            ] : null,
        ]);
    }
}
