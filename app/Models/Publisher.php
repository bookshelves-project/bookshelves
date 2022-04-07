<?php

namespace App\Models;

use App\Models\Traits\HasFirstChar;
use App\Models\Traits\HasNegligible;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    use HasFactory;
    use HasNegligible;

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

    public function getShowLinkAttribute(): string
    {
        return route('api.publishers.show', [
            'publisher_slug' => $this->slug,
        ]);
    }

    public function getBooksLinkAttribute(): string
    {
        return route('api.publishers.show.books', [
            'publisher_slug' => $this->slug,
        ]);
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class)->orderBy('serie_id')->orderBy('volume');
    }
}
