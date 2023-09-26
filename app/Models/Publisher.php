<?php

namespace App\Models;

use App\Traits\HasFirstChar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kiwilan\Steward\Traits\HasShowRoute;
use Kiwilan\Steward\Traits\HasSlug;

/**
 * @property null|int $books_count
 */
class Publisher extends Model
{
    use HasFactory;
    use HasFirstChar;
    use HasShowRoute;
    use HasSlug;

    protected $fillable = [
        'name',
    ];

    protected $appends = [
        'first_char',
    ];

    protected $withCount = [
        'books',
    ];

    public function getBooksRouteAttribute()
    {
        return route('api.publishers.books', [
            'publisher_slug' => $this->slug,
        ]);
    }

    /**
     * Relationships.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class)
            ->orderBy('serie_id')
            ->orderBy('volume');
    }
}
