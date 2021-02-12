<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'     => $this->id,
            'text'   => $this->text,
            'rating' => $this->rating ? $this->rating : null,
            'user'   => [
                'id'      => $this->user->id,
                'name'    => $this->user->name,
                'picture' => $this->user->profile_photo_url,
            ],
            'createdAt'  => $this->created_at,
            'updatedAt'  => $this->updated_at,
        ];
    }
}
