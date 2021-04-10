<?php

namespace App\Http\Resources;

use App\Models\Comment;
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
        /** @var Comment $comment */
        $comment = $this;

        $for = strtolower(str_replace('App\\Models\\', '', $comment->commentable_type));
        $cover = $comment->commentable->cover;
        $entity = $comment->commentable;
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
            'meta' => [
                'type'   => 'comment',
                'for'    => $for,
                'author' => $comment->commentable->author?->slug,
                'slug'   => $comment->commentable->slug,
            ],
            'id'     => $comment->id,
            'text'   => $comment->text,
            'rating' => $comment->rating ? $comment->rating : null,
            'user'   => [
                'id'      => $comment->user->id,
                'name'    => $comment->user->name,
                'picture' => $comment->user->profile_photo_url,
            ],
            'createdAt' => $comment->created_at,
            'updatedAt' => $comment->updated_at,
            'title'     => $title,
            'picture'   => $comment->commentable->image_thumbnail,
        ];
    }
}
