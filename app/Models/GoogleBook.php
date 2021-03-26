<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GoogleBook extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'preview_link',
        'buy_link',
        'retail_price',
        'retail_price_currency',
        'created_at',
    ];

    public function book(): HasOne
    {
        return $this->hasOne(Book::class);
    }
}
