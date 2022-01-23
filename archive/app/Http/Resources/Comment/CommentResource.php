<?php

namespace App\Http\Resources\Comment;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Comment $resource
 */
class CommentResource extends JsonResource
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
        $for = strtolower(str_replace('App\\Models\\', '', $this->resource->commentable_type));
        $entity = $this->resource->commentable;
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
                'type' => 'comment',
                'for' => $for,
                // @phpstan-ignore-next-line
                'author' => $this->resource->commentable->meta_author,
                // @phpstan-ignore-next-line
                'slug' => $this->resource->commentable->slug,
            ],
            'id' => $this->resource->id,
            'text' => $this->resource->text,
            'rating' => $this->resource->rating ? $this->resource->rating : null,
            'user' => $this->resource->user ? [
                'id' => $this->resource->user->id,
                'name' => $this->resource->user->name,
                'slug' => $this->resource->user->slug,
                'avatar' => $this->resource->user->avatar,
                'color' => $this->resource->user->color,
            ] : null,
            'createdAt' => $this->resource->created_at,
            'updatedAt' => $this->resource->updated_at,
            'title' => $title,
            // @phpstan-ignore-next-line
            'cover' => $this->resource->commentable->cover_thumbnail,
        ];
    }
}
