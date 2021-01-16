<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EpubResource extends JsonResource
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
            'name' => $this->name,
            // 'path' => config('app.url').'/'.$this->path,
            'download'              => config('app.url').'/api/books/download/'.$this->book->author->slug.'/'.$this->book->slug,
            'size'                  => $this->size,
        ];
    }
}
