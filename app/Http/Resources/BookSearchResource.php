<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookSearchResource extends JsonResource
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
        $author = null;
        if ($this->author) {
            $author = $this->author;
        }

        return [
            'title'                 => $this->title,
            'slug'                  => $this->slug,
            'author'                => $author ? $author->slug : null,
        ];
    }
}
