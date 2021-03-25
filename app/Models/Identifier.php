<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Identifier.
 *
 * @property int                   $id
 * @property string|null           $isbn
 * @property string|null           $isbn13
 * @property string|null           $doi
 * @property string|null           $amazon
 * @property string|null           $google
 * @property \App\Models\Book|null $book
 * @method static \Illuminate\Database\Eloquent\Builder|Identifier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Identifier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Identifier query()
 * @method static \Illuminate\Database\Eloquent\Builder|Identifier whereAmazon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Identifier whereDoi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Identifier whereGoogle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Identifier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Identifier whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Identifier whereIsbn13($value)
 * @mixin \Eloquent
 */
class Identifier extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'isbn',
        'isbn13',
        'doi',
        'amazon',
        'google',
    ];

    public function book(): HasOne
    {
        return $this->hasOne(Book::class);
    }
}
