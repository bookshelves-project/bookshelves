<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'type'                  => [
                'morph'  => 'book',
                'entity' => 'comment',
            ],
            'id'                    => $this->id,
            'text'                  => $this->text,
            'rating'                => $this->rating ? $this->rating : null,
            'user'                  => [
                'id'      => $this->user->id,
                'name'    => $this->user->name,
                'picture' => $this->user->profile_photo_url,
            ],
            'createdAt'  => $this->created_at,
            'updatedAt'  => $this->updated_at,
            'authorSlug' => $this->books[0]->author->slug,
            'cover'      => $this->books[0]->cover->basic,
            'slug'       => $this->books[0]->slug,
            'book'       => [
                'title'  => $this->books[0]->title,
            ],
        ];
    }
}
