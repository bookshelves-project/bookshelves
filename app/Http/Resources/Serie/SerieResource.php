<?php

namespace App\Http\Resources\Serie;

use App\Http\Resources\Book\BookSerieResource;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Tag\TagLightResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Serie $resource
 */
class SerieResource extends JsonResource
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
        return array_merge(SerieLightResource::make($this->resource)->toArray($request), [
            'meta' => [
                'entity' => $this->resource->getClassName(),
                'slug' => $this->resource->slug,
                'author' => $this->resource->meta_author,
                'show' => $this->resource->show_link,
                'books' => $this->resource->books_link,
                'comments' => $this->resource->comments_link,
            ],
            'description' => $this->resource->description,
            'link' => $this->resource->link,
            'cover' => [
                'thumbnail' => $this->resource->cover_thumbnail,
                'og' => $this->resource->cover_og,
                'simple' => $this->resource->cover_simple,
                'color' => $this->resource->cover_color,
            ],
            'tags' => TagLightResource::collection($this->resource->tags_list),
            'genres' => TagLightResource::collection($this->resource->genres_list),
            'download' => $this->resource->file_main,
            'files' => $this->resource->files_list,
            'isFavorite' => $this->resource->is_favorite,
            'comments' => CommentResource::collection($this->resource->comments),
        ]);
    }
}
