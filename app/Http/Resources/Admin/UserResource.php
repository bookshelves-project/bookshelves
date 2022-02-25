<?php

namespace App\Http\Resources\Admin;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * @property User $resource
 */
class UserResource extends JsonResource
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
            'can_be_updated' => Auth::user()->canUpdate($this->resource),
            'can_be_impersonated' => Auth::user()->canImpersonate($this->resource),
        ] + $this->resource->toArray();
    }
}
