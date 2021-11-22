<?php

namespace App\Http\Resources\Tag;

use App\Enums\CountSizeEnum;
use App\Models\Book;
use App\Models\TagExtend;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property TagExtend $resource
 */
class TagLightResource extends JsonResource
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
        $count = 0;
        // $total = Book::count();
        $count = $this->resource->books_count;
        // $count = Book::withAllTags([$this->resource])->count();
        // $percentage = intval($count * 100 / $total);

        // switch ($percentage) {
        //     case $percentage <= 5:
        //         $size = CountSizeEnum::XS();
        //         break;

        //     case $percentage <= 10:
        //         $size = CountSizeEnum::SM();
        //         break;

        //     case $percentage <= 20:
        //         $size = CountSizeEnum::MD();
        //         break;

        //     case $percentage <= 30:
        //         $size = CountSizeEnum::LG();
        //         break;

        //     case $percentage <= 50:
        //         $size = CountSizeEnum::XL();
        //         break;

        //     default:
        //         $size = CountSizeEnum::XS();
        //         break;
        // }
        $type = $this->resource->type;

        return [
            'name' => $this->resource->name,
            'type' => $this->resource->type,
            'count' => $count,
            'first_char' => $this->resource->first_char,
            // 'size' => $size,
            'meta' => [
                'slug' => $this->resource->slug,
                'books' => route('api.tags.show.books', [
                    'tag' => $this->resource->slug,
                ]),
                'show' => route('api.tags.show', [
                    'tag' => $this->resource->slug,
                ]),
            ],
        ];
    }
}
