<?php

namespace App\Http\Resources;

use App\Models\Favoritable;
use Illuminate\Http\Resources\Json\JsonResource;

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
        $cover = $favoritable->favoritable->cover;
        $entity = $favoritable->favoritable;
        $title = null;

        switch ($for) {
            case 'book':
                $title = $entity->title;
                break;

            case 'serie':
                $title = $entity->title;
                break;

            case 'author':
                $title = $entity->name;
                break;

            default:
                $title = null;
                break;
        }

        return [
            'meta'                  => [
                'type'        => 'favorite',
                'for'         => $for,
                'author'      => $favoritable->favoritable->author?->slug,
                'slug'        => $favoritable->favoritable->slug,
            ],
            'title'   => $title,
            'picture' => $favoritable->favoritable->image_thumbnail,
        ];
    }
}