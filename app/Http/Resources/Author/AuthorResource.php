<?php

namespace App\Http\Resources\Author;

use App\Http\Resources\Comment\CommentResource;
use App\Models\Author;
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

        return array_merge($resource, [
            'meta' => [
                'entity' => $this->resource->getClassName(),
                'slug' => $author->slug,
                'show' => $author->show_link,
                'books' => $author->show_books_link,
                'series' => $author->show_series_link,
            ],
            'description' => $author->description,
            'link' => $author->link,
            'sizes' => $author->sizes,
            'download' => $author->download_link,
            'isFavorite' => $author->is_favorite,
            'comments' => CommentResource::collection($author->comments),
        ]);
    }
}
