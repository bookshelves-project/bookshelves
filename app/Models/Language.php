<?php

namespace App\Models;

use App\Models\Traits\HasFirstChar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

/**
 * @property null|int $books_count
 * @property null|int $series_count
 */
class Language extends Model
{
    use HasFirstChar;
    use HasFactory;
    use HasTranslations;

    public $incrementing = false;

    public $timestamps = false;

    public $translatable = [
        'name',
    ];

    protected $primaryKey = 'slug';

    protected $keyType = 'string';

    protected $fillable = [
        'slug',
        'name',
    ];

    protected $withCount = [
        // 'books',
        // 'series',
    ];

    protected $appends = [
        'first_char',
        'id',
    ];

    public function getShowLinkAttribute(): string
    {
        return route('api.languages.show', [
            'language_slug' => $this->slug,
        ]);
    }

    public function getIdAttribute(): string
    {
        return $this->slug;
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
