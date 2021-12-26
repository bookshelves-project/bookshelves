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

        return array_merge($resource, [
            'lastname' => $author->lastname,
            'firstname' => $author->firstname,
            'cover' => [
                'thumbnail' => $author->cover_thumbnail,
                'og' => $author->cover_og,
                'simple' => $author->cover_simple,
                'color' => $this->resource->cover_color,
            ],
            'count' => [
                'books' => $author->books_count,
                'series' => $author->series_count,
            ],
        ]);
    }
}
