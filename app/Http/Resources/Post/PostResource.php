<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\Tag\TagCollectionResource;
use App\Http\Resources\TeamMember\TeamMemberCollectionResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Post $resource
 */
class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            ...PostCollectionResource::make($this->resource)->toArray($request),
            'body' => $this->resource->body,
            'youtube_id' => $this->resource->youtube_id,
            'cta' => $this->resource->cta,
            'image_extra' => $this->resource->getMediable('image_extra'),
            'seo' => $this->resource->seo,
            'tags' => TagCollectionResource::collection($this->resource->tags),
            'authors' => TeamMemberCollectionResource::collection($this->resource->authors),
            'related' => PostCollectionResource::collection($this->resource->related),
            'recent' => PostCollectionResource::collection($this->resource->recent),
        ];
    }
}
