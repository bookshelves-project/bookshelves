<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'title'       => $this->title,
            'slug'        => $this->slug,
            'creator'     => $this->creator,
            'description' => $this->description,
            'language'    => $this->language,
            'date'        => $this->date,
            'contributor' => $this->contributor,
            'identifier'  => $this->identifier,
            'subject'     => $this->subject,
            'publisher'   => $this->publisher,
            'cover'       => config('app.url').'/'.$this->cover,
            'path'        => config('app.url').'/'.$this->path,
        ];
    }
}
