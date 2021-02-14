<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteCollection extends JsonResource
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
        $for = strtolower(str_replace('App\\Models\\', '', $this->favoritable_type));
        $cover = $this->favoritable->cover;
        $entity = $this->favoritable;
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
                'author' => $this->favoritable->author?->slug,
                'slug'        => $this->favoritable->slug,
            ],
            'title' => $title,
            'image' => $this->favoritable->image,
        ];
    }
}
