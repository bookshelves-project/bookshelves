<?php

namespace App\Models;

use App\Models\Traits\HasFirstChar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * @property null|int $books_count
 */
class Language extends Model implements Sortable
{
    use HasFirstChar;
    use SortableTrait;

    public $incrementing = false;
    public $timestamps = false;

    protected $primaryKey = 'slug';
    protected $keyType = 'string';
    protected $fillable = [
        'slug',
        'name',
    ];

    protected $hidden = [
        'order_column',
    ];
    protected $withCount = [
        'books',
    ];
    protected $appends = [
        'first_char',
    ];

    public function getShowLinkAttribute(): string
    {
        return route('api.v1.languages.show', [
            'language_slug' => $this->slug,
        ]);
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function series(): HasMany
    {
        return $this->hasMany(Serie::class);
    }
}
