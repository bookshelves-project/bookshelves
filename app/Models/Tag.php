<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Tag.
 *
 * @property int                                                         $id
 * @property string|null                                                 $slug
 * @property string|null                                                 $name
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property int|null                                                    $books_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereSlug($value)
 * @mixin \Eloquent
 */
class Tag extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'slug',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }
}
