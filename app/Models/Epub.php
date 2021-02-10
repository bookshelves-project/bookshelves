<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Epub
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $path
 * @property string|null $size
 * @property string|null $size_bytes
 * @property-read \App\Models\Book|null $book
 * @method static \Illuminate\Database\Eloquent\Builder|Epub newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Epub newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Epub query()
 * @method static \Illuminate\Database\Eloquent\Builder|Epub whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Epub whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Epub wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Epub whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Epub whereSizeBytes($value)
 * @mixin \Eloquent
 */
class Epub extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'path',
        'size',
        'size_bytes',
    ];

    public function book(): HasOne
    {
        return $this->hasOne(Book::class);
    }
}
