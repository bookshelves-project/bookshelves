<?php

namespace App\Http\Resources\Cms;

use App\Models\Book;
use App\Models\Cms\Application;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Application $resource
 */
class ApplicationResource extends JsonResource
{
    /**
     * Transform the Book into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @mixin Book
     */
    public function toArray($request): array
    {
        $lang = $request->lang ?? 'en';
        app()->setLocale($lang);

        return [
            'name' => $this->resource->name,
            'title_template' => $this->resource->title_template,
            'slug' => $this->resource->slug,
            'favicon' => $this->resource->favicon,
            'icon' => $this->resource->icon,
            'logo' => $this->resource->logo,
            'og' => $this->resource->open_graph,
            'meta_title' => $this->resource->meta_title,
            'meta_description' => $this->resource->meta_description,
            'meta_author' => $this->resource->meta_author,
            'meta_twitter_creator' => $this->resource->meta_twitter_creator,
            'meta_twitter_site' => $this->resource->meta_twitter_site,
        ];
    }
}
