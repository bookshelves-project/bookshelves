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
        $for = strtolower(str_replace('App\\Models\\', '', $this->commentable_type));
        $cover = $this->commentable->cover;
        $entity = $this->commentable;
        $title = null;
        
        switch ($for) {
            case 'book':
                $title = $entity->title;
                break;

            case 'serie':
                $title = $entity->title;
                break;

            case 'author':
                $title = $entity->name;
                break;
    
            default:
                $title = null;
                break;
        }

        return [
            'meta'                  => [
                'type'        => 'comment',
                'for'         => $for,
                'author' => $this->commentable->author?->slug,
                'slug'        => $this->commentable->slug,
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
            'title' => $title,
            'cover' => $cover,
            // 'authorSlug' => $this->books[0]?->author->slug,
            // 'cover'      => $this->books[0]?->cover->basic,
            // 'slug'       => $this->books[0]?->slug,
            // 'book'       => [
            //     'title'  => $this->books[0]?->title,
            // ],
        ];
    }
}
