<?php

namespace App\Models;

use App\Models\Traits\HasFirstChar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property null|int $books_count
 */
class Publisher extends Model
{
    use HasFirstChar;
    use HasSlug;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'slug',
    ];

    protected $appends = [
        'first_char',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
        ;
    }

    public function scopeWhereIsNegligible(Builder $query, string $negligible)
    {
        $negligible = filter_var($negligible, FILTER_VALIDATE_BOOLEAN);

        return $negligible ? $query : $query->whereHas('books', count: 3);
    }

    public function getShowLinkAttribute(): string
    {
        return route('api.v1.publishers.show', [
            'publisher_slug' => $this->slug,
        ]);
    }

    public function getShowBooksLinkAttribute(): string
    {
        return route('api.v1.publishers.show.books', [
            'publisher_slug' => $this->slug,
        ]);
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class)->orderBy('serie_id')->orderBy('volume');
    }
}
