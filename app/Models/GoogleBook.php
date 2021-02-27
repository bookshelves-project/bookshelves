<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoogleBook extends Model
{
    use HasFactory;

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
