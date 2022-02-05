<?php

namespace App\Http\Resources\Admin;

use App\Models\Language;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Language $resource
 */
class LanguageResource extends JsonResource
{
    public static $wrap;

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
        ] + $this->resource->toArray();
    }
}
