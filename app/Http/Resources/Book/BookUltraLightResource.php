<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Author\AuthorUltraLightResource;
use App\Http\Resources\Language\LanguageLightResource;
use App\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            'type' => $this->resource->type->i18n(),
            'meta' => [
                'entity' => $this->resource->getClassName(),
                'slug' => $this->resource->slug,
                'author' => $this->resource->meta_author,
                'show' => $this->resource->show_link,
            ],
            'authors' => AuthorUltraLightResource::collection($this->resource->authors),
            'summary' => Str::limit($this->resource->description, 140),
            'language' => LanguageLightResource::make($this->resource->language),
            'releasedOn' => $this->resource->released_on,
            'cover' => [
                'thumbnail' => $this->resource->cover_thumbnail,
                'simple' => $this->resource->cover_simple,
                'color' => $this->resource->cover_color,
            ],
            'volume' => $this->resource->volume,
        ];
    }
}
