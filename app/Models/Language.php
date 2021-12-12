<?php

namespace App\Models;

use App\Models\Traits\HasFirstChar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Language.
 *
 * @property null|string                                                  $slug
 * @property null|string                                                  $name
 * @property \App\Models\Book[]|\Illuminate\Database\Eloquent\Collection  $books
 * @property null|int                                                     $books_count
 * @property mixed                                                        $first_char
 * @property \App\Models\Serie[]|\Illuminate\Database\Eloquent\Collection $series
 * @property null|int                                                     $series_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereSlug($value)
 * @mixin \Eloquent
 */
class Language extends Model
{
    use HasFirstChar;

    public $incrementing = false;
    public $timestamps = false;

    protected $primaryKey = 'slug';
    protected $keyType = 'string';
    protected $fillable = [
        'slug',
        'name',
    ];

    protected $withCount = [
        'books',
    ];
    protected $appends = [
        'first_char',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function series(): HasMany
    {
        return $this->hasMany(Serie::class);
    }
}
