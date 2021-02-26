<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GoogleBookResource extends JsonResource
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
            'preview_link'          => $this->preview_link,
            'buy_link'              => $this->buy_link,
            'retail_price'          => $this->retail_price,
            'retail_price_currency' => $this->retail_price_currency,
            'created_at'            => $this->created_at,
        ];
    }
}
