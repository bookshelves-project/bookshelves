<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IdentifierResource extends JsonResource
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
            'isbn'   => $this->isbn,
            'isbn13' => $this->isbn13,
            'doi'    => $this->doi,
            'amazon' => $this->amazon,
            'google' => $this->google,
        ];
    }
}
