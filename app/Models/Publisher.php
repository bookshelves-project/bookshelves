<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Publisher.
 *
 * @property int                                                         $id
 * @property string|null                                                 $slug
 * @property string|null                                                 $name
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property int|null                                                    $books_count
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher query()
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Publisher whereSlug($value)
 * @mixin \Eloquent
 */
class Publisher extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'slug',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class)->orderBy('serie_id')->orderBy('serie_number');
    }
}
