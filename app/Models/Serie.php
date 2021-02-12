<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\Serie.
 *
 * @property int                                                         $id
 * @property string|null                                                 $title
 * @property string|null                                                 $title_sort
 * @property string|null                                                 $slug
 * @property string|null                                                 $cover
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property int|null                                                    $books_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Serie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serie whereTitleSort($value)
 * @mixin \Eloquent
 */
class Serie extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'title',
        'title_sort',
        'slug',
        'cover',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class)->with('epub')->orderBy('serie_number');
    }

    public function favorites(): MorphToMany
    {
        return $this->morphToMany(User::class, 'favoritable');
    }

    public function comments(): MorphToMany
    {
        return $this->morphToMany(Comment::class, 'commentable');
    }
}
