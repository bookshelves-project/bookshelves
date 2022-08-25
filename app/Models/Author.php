<?php

namespace App\Models;

use App\Enums\AuthorRoleEnum;
use App\Traits\HasClassName;
use App\Traits\HasCovers;
use App\Traits\HasFavorites;
use App\Traits\HasReviews;
use App\Traits\HasSlug;
use App\Traits\HasTagsAndGenres;
use App\Traits\HasWikipediaItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;

class Author extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use HasFavorites;
    use HasReviews;
    use HasWikipediaItem;
    use HasTagsAndGenres;
    use HasCovers;
    use HasClassName;
    use Searchable;

    protected $fillable = [
        'lastname',
        'firstname',
        'name',
        'role',
        'description',
        'link',
        'note',
    ];

    protected $casts = [
        'role' => AuthorRoleEnum::class,
    ];

    /**
     * Relationships.
     */

    /**
     * Get all of the books that are assigned this author.
     */
    public function books(): MorphToMany
    {
        return $this->morphedByMany(Book::class, 'authorable')
            ->orderBy('slug_sort')
            ->orderBy('volume')
        ;
    }

    /**
     * Get all of the series that are assigned this author.
     */
    public function series(): MorphToMany
    {
        return $this->morphedByMany(Serie::class, 'authorable')
            ->orderBy('slug_sort')
            ->withCount('books')
        ;
    }

    /**
     * Scout.
     */
    public function searchableAs()
    {
        $app = config('bookshelves.slug');

        return "{$app}_authors";
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            // 'picture' => $this->cover_thumbnail,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
