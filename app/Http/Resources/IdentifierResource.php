<?php

namespace App\Http\Resources;

use App\Models\Identifier;
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
        /** @var Identifier $identifier */
        $identifier = $this;

        return [
            'isbn'   => $identifier->isbn,
            'isbn13' => $identifier->isbn13,
            'doi'    => $identifier->doi,
            'amazon' => $identifier->amazon,
            'google' => $identifier->google,
        ];
    }
}
