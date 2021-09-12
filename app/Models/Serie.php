<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use Laravel\Scout\Searchable;
use App\Utils\BookshelvesTools;
use App\Models\Traits\HasCovers;
use App\Models\Traits\HasAuthors;
use Spatie\MediaLibrary\HasMedia;
use App\Models\Traits\HasComments;
use App\Models\Traits\HasLanguage;
use App\Models\Traits\HasClassName;
use App\Models\Traits\HasFavorites;
use App\Models\Traits\HasSelections;
use App\Models\Traits\HasTagsAndGenres;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Serie extends Model implements HasMedia
{
    use HasFactory;
    use HasTags;
    use HasClassName;
    use HasCovers;
    use HasAuthors;
    use HasFavorites;
    use HasComments;
    use HasSelections;
    use HasLanguage;
    use HasTagsAndGenres;
    use Searchable;

    protected $fillable = [
        'title',
        'title_sort',
        'slug',
        'description',
        'link',
    ];

    protected $with = [
        'language',
    ];

    public function getContentOpdsAttribute(): string
    {
        return $this->books->count() . ' books';
    }

    public function getSizeAttribute(): string
    {
        $size = [];
        $serie = Serie::whereSlug($this->slug)->with('books.media')->first();
        $books = $serie->books;
        foreach ($books as $key => $book) {
            array_push($size, $book->getMedia('epubs')->first()?->size);
        }
        $size = array_sum($size);
        $size = BookshelvesTools::humanFilesize($size);

        return $size;
    }

    /**
     * Get Books into Serie, by volume order
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class)->orderBy('volume');
    }
}
