<?php

namespace App\Http\Resources\Author;

use App\Models\Author;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorLightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        /** @var Author $author */
        $author = $this;

        $resource = AuthorUltraLightResource::make($author)->toArray($request);
        $resource = array_merge($resource, [
            'lastname'  => $author->lastname,
            'firstname' => $author->firstname,
            'picture'   => [
                'thumbnail'      => $author->image_thumbnail,
                'og'             => $author->image_og,
                'simple'         => $author->image_simple,
                'color'          => $this->resource->image_color,
            ],
            'count' => $author->books_count,
        ]);

        return $resource;
    }
}
