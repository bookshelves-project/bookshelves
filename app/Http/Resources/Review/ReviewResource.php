<?php

namespace App\Http\Resources\Review;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Review $resource
 */
class ReviewResource extends JsonResource
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
        $for = strtolower(str_replace('App\\Models\\', '', $this->resource->reviewable_type));
        $entity = $this->resource->reviewable;
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
                'type' => 'review',
                'for' => $for,
                // @phpstan-ignore-next-line
                'author' => $this->resource->reviewable->meta_author,
                // @phpstan-ignore-next-line
                'slug' => $this->resource->reviewable->slug,
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
            'cover' => $this->resource->reviewable->cover_thumbnail,
        ];
    }
}
