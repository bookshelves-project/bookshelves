<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\GoogleBook
 *
 * @property int $id
 * @property string|null $preview_link
 * @property string|null $buy_link
 * @property int|null $retail_price
 * @property string|null $retail_price_currency
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\Book|null $book
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook query()
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereBuyLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook wherePreviewLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereRetailPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereRetailPriceCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GoogleBook whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
