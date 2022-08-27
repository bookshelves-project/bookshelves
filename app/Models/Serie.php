<?php

namespace App\Models;

use App\Enums\BookTypeEnum;
use App\Traits\HasAuthors;
use App\Traits\HasBookType;
use App\Traits\HasClassName;
use App\Traits\HasCovers;
use App\Traits\HasFavorites;
use App\Traits\HasLanguage;
use App\Traits\HasReviews;
use App\Traits\HasSelections;
use App\Traits\HasTagsAndGenres;
use App\Traits\HasWikipediaItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Translatable\HasTranslations;

class Serie extends Model implements HasMedia
{
    use HasFactory;
    use HasAuthors;
    use HasFavorites;
    use HasReviews;
    use HasLanguage;
    use HasTagsAndGenres;
    use HasBookType;
    use HasWikipediaItem;
    use HasCovers;
    use HasSelections;
    use HasClassName;
    use HasTranslations;
    use Searchable;

    public $translatable = [
        // 'title',
        'description',
    ];

    protected $fillable = [
        'title',
        'slug_sort',
        'slug',
        'type',
        'description',
        'link',
    ];

    protected $casts = [
        'type' => BookTypeEnum::class,
    ];

    /**
     * Relationships.
     */

    /**
     * Get Books into Serie, by volume order.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class)
            ->orderBy('volume')
        ;
    }

    /**
     * Get available Books into Serie, by volume order.
     */
    // public function booksAvailable(): HasMany
    // {
    //     return $this->hasMany(Book::class)
    //         ->where('is_disabled', false)
    //         ->orderBy('volume')
    //     ;
    // }

    /**
     * Scout.
     */
    public function searchableAs()
    {
        $app = config('bookshelves.slug');

        return "{$app}_series";
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            // 'picture' => $this->cover_thumbnail,
            'author' => $this->authors_names,
            'description' => $this->description,
            'tags' => $this->tags_string,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
