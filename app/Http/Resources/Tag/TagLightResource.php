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
        //         $size = CountSizeEnum::xs;
        //         break;

        //     case $percentage <= 10:
        //         $size = CountSizeEnum::sm;
        //         break;

        //     case $percentage <= 20:
        //         $size = CountSizeEnum::md;
        //         break;

        //     case $percentage <= 30:
        //         $size = CountSizeEnum::lg;
        //         break;

        //     case $percentage <= 50:
        //         $size = CountSizeEnum::xl;
        //         break;

        //     default:
        //         $size = CountSizeEnum::xs;
        //         break;
        // }
        $type = $this->resource->type;

        return [
            'name' => $this->resource->name,
            'type' => $this->resource->type,
            'count' => $count,
            'firstChar' => $this->resource->first_char,
            // 'size' => $size,
            'meta' => [
                'slug' => $this->resource->slug,
                'books' => $this->resource->show_books_link,
                'show' => $this->resource->show_link,
            ],
        ];
    }
}
