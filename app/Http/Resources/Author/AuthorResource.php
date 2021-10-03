<?php

namespace App\Http\Resources\Author;

use App\Http\Resources\Book\BookLightResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\Serie\SerieLightResource;
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
                'slug' => $author->slug,
                'show' => $author->show_link,
                'books' => $author->show_books_link,
                'series' => $author->show_series_link,
            ],
            'description' => $author->description,
            'link' => $author->link,
            'size' => $author->size,
            'download' => $author->download_link,
            // 'series' => SerieLightResource::collection($author->series),
            // 'books' => BookLightResource::collection($author->books),
            'isFavorite' => $author->is_favorite,
            'comments' => CommentResource::collection($author->comments),
        ]);
    }
}
