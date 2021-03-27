<?php

namespace App\Http\Resources\Book;

use App\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;

class BookSerieResource extends JsonResource
{
    /**
     * Transform the Book into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @mixin Book
     *
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Book $book */
        $book = $this;

        $resource = BookUltraLightResource::make($book)->toArray($request);
        $resource = array_merge($resource, [
            'picture'     => [
                'base'      => $book->image_thumbnail,
                'openGraph' => $book->image_open_graph,
                'original'  => $book->image_original,
            ],
        ]);

        return $resource;
    }
}
