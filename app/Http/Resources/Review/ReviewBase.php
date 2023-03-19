<?php

namespace App\Http\Resources\Review;

use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Review $resource
 */
class ReviewBase extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Author|Book|Serie */
        $reviewable = $this->resource->reviewable;

        return [
            'meta' => [
                'type' => 'review',
                'entity' => $reviewable->entity,
                'author' => $reviewable->meta_author,
                'slug' => $reviewable->slug,
            ],
            'id' => $this->resource->id,
            'text' => $this->resource->text,
            'rating' => $this->resource->rating ?? null,
            'user' => $this->resource->user ? [
                'id' => $this->resource->user->id,
                'name' => $this->resource->user->name,
                'slug' => $this->resource->user->username,
                'avatar' => $this->resource->user->avatar,
                'color' => $this->resource->user->color,
            ] : null,
            'title' => $reviewable->title,
            'cover' => $reviewable->cover_thumbnail,
            'color' => $reviewable->cover_color,
            'createdAt' => $this->resource->created_at,
            'updatedAt' => $this->resource->updated_at,
        ];
    }
}
