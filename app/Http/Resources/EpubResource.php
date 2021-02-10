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
        $downloadLink = null;
        try {
            $downloadLink = config('app.url').'/api/download/book/'.$this->book->author->slug.'/'.$this->book->slug;
        } catch (\Throwable $th) {
        }

        return [
            'name' => $this->name,
            // 'path' => config('app.url').'/'.$this->path,
            'download'              => $downloadLink,
            'size'                  => $this->size,
        ];
    }
}
