<?php

namespace App\Models;

use App\Models\Traits\HasFirstChar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Publisher.
 *
 * @property int                                                         $id
 * @property null|string                                                 $slug
 * @property null|string                                                 $name
 * @property \App\Models\Book[]|\Illuminate\Database\Eloquent\Collection $books
 * @property null|int                                                    $books_count
 * @property mixed                                                       $first_char
 * @property string                                                      $show_link
 *
 * @method static Builder|Publisher newModelQuery()
 * @method static Builder|Publisher newQuery()
 * @method static Builder|Publisher query()
 * @method static Builder|Publisher whereId($value)
 * @method static Builder|Publisher whereIsNegligible(string $negligible)
 * @method static Builder|Publisher whereName($value)
 * @method static Builder|Publisher whereSlug($value)
 * @mixin \Eloquent
 */
class Publisher extends Model
{
    use HasFirstChar;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'slug',
    ];

    protected $appends = [
        'first_char',
    ];

    public function scopeWhereIsNegligible(Builder $query, string $negligible)
    {
        $negligible = filter_var($negligible, FILTER_VALIDATE_BOOLEAN);

        return $negligible ? $query : $query->whereHas('books', count: 3);
    }

    public function getShowLinkAttribute(): string
    {
        return route('api.publishers.show', [
            'publisher' => $this->slug,
        ]);
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class)->orderBy('serie_id')->orderBy('volume');
    }
}
