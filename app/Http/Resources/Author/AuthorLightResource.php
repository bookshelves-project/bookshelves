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
            'picture' => [
                'base'      => $author->image_thumbnail,
                'openGraph' => $author->image_open_graph,
            ],
            'booksNumber' => count($author->books),
        ]);

        return $resource;
    }
}
