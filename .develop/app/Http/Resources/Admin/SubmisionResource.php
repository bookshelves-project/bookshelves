<?php

namespace App\Http\Resources\Admin;

use App\Models\Submission;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Submission $resource
 */
class SubmisionResource extends JsonResource
{
    public static $wrap;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->toArray();
    }
}
