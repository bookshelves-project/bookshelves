<?php

namespace App\Http\Resources;

use App\Models\GoogleBook;
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
        /** @var GoogleBook $googleBook */
        $googleBook = $this;

        return [
            'preview_link' => $googleBook->preview_link,
            'buy_link' => $googleBook->buy_link,
            'retail_price' => $googleBook->retail_price,
            'retail_price_currency' => $googleBook->retail_price_currency,
            'created_at' => $googleBook->created_at,
        ];
    }
}
