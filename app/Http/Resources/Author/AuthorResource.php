<?php

namespace App\Http\Resources\Author;

use App\Models\Author;
use App\Http\Resources\CommentResource;
use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\Serie\SerieLightResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
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

        $resource = AuthorLightResource::make($author)->toArray($request);
        $resource = array_merge($resource, [
            'description'            => $author->description,
            'descriptionLink'        => $author->description_link,
            'size'                   => $author->size,
            'download'               => $author->download_link,
            'series'                 => SerieLightResource::collection($author->series),
            'books'                  => BookLightResource::collection($author->books),
            'isFavorite'             => $author->is_favorite,
            'comments'               => CommentResource::collection($author->comments),
        ]);

        return $resource;
    }
}
