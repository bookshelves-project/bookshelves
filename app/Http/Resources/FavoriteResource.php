<?php

namespace App\Http\Resources;

use App\Models\Favoritable;
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
        $for = strtolower(str_replace('App\\Models\\', '', $this->resource->favoritable_type));
        $entity = $this->resource->favoritable;
        $title = null;

        switch ($for) {
            case 'book':
                // @phpstan-ignore-next-line
                $title = $entity->title;

                break;

            case 'serie':
                // @phpstan-ignore-next-line
                $title = $entity->title;

                break;

            case 'author':
                // @phpstan-ignore-next-line
                $title = $entity->name;

                break;

            default:
                $title = null;

                break;
        }
        // dump($this->resource->favoritable);

        return [
            'meta' => [
                'type' => 'favorite',
                'for' => $for,
                // @phpstan-ignore-next-line
                'author' => $this->resource->favoritable->meta_author,
                // @phpstan-ignore-next-line
                'slug' => $this->resource->favoritable->slug,
            ],
            'title' => $title,
            // @phpstan-ignore-next-line
            'cover' => $this->resource->favoritable->cover_thumbnail,
            'createdAt' => $this->resource->created_at,
        ];
    }
}
