<?php

namespace App\Http\Resources\Api\Cms;

use App\Models\Book;
use App\Models\Cms\Navigation;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Navigation $resource
 */
class NavigationResource extends JsonResource
{
    /**
     * Transform the Book into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @mixin Book
     */
    public function toArray($request): array
    {
        $lang = $request->lang ?? 'en';
        app()->setLocale($lang);

        return [
            'title' => $this->resource->title,
            'route' => $this->resource->route,
            'category' => $this->resource->category,
        ];
    }
}
