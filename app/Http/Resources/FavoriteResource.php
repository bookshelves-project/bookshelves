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
        /** @var Favoritable $favoritable */
        $favoritable = $this;

        $for = strtolower(str_replace('App\\Models\\', '', $favoritable->favoritable_type));
        $entity = $favoritable->favoritable;
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

        return [
            'meta' => [
                'type' => 'favorite',
                'for' => $for,
                // @phpstan-ignore-next-line
                'author' => $favoritable->favoritable->meta_author,
                // @phpstan-ignore-next-line
                'slug' => $favoritable->favoritable->slug,
            ],
            'title' => $title,
            // @phpstan-ignore-next-line
            'cover' => $favoritable->favoritable->cover_thumbnail,
            'createdAt' => $favoritable->created_at,
        ];
    }
}
