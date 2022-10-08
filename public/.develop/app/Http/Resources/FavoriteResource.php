<?php

namespace App\Http\Resources;

use App\Models\Author;
use App\Models\Book;
use App\Models\Favoritable;
use App\Models\Serie;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Favoritable $resource
 */
class FavoriteResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        /** @var Author|Book|Serie */
        $favoritable = $this->resource->favoritable;

        return [
            'meta' => [
                'type' => 'favorite',
                'entity' => $favoritable->entity,
                'author' => $favoritable->meta_author,
                'slug' => $favoritable->slug,
            ],
            'title' => $favoritable->title ?? $favoritable->name,
            'cover' => $favoritable->cover_thumbnail,
            'color' => $favoritable->cover_color,
            'createdAt' => $this->resource->created_at,
            'updatedAt' => $this->resource->updated_at,
        ];
    }
}
