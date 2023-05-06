<?php

namespace App\Models;

use App\Engines\Book\Converter\WikipediaItemConverter;
use App\Enums\AuthorRoleEnum;
use App\Traits\HasCovers;
use App\Traits\HasFavorites;
use App\Traits\HasReviews;
use App\Traits\HasTagsAndGenres;
use App\Traits\IsEntity;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Kiwilan\Steward\Queries\Filter\GlobalSearchFilter;
use Kiwilan\Steward\Services\Wikipedia\Wikipediable;
use Kiwilan\Steward\Services\Wikipedia\WikipediaItem;
use Kiwilan\Steward\Traits\HasMetaClass;
use Kiwilan\Steward\Traits\HasSearchableName;
use Kiwilan\Steward\Traits\HasSlug;
use Kiwilan\Steward\Traits\Queryable;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @property null|int $books_count
 * @property null|int $series_count
 * @property \App\Enums\BookTypeEnum|null $type
 */
class Author extends Model implements HasMedia, Wikipediable
{
    use HasFactory;
    use HasSlug;
    use IsEntity;
    use HasFavorites;
    use HasReviews;
    use HasTagsAndGenres;
    use HasCovers;
    use HasMetaClass;
    use Searchable;
    use Queryable;
    use HasSearchableName;

    protected $query_default_sort = 'lastname';

    protected $query_default_sort_direction = 'asc';

    protected $query_allowed_sorts = ['id', 'firstname', 'lastname', 'name', 'role', 'books_count', 'series_count', 'created_at', 'updated_at'];

    protected $query_limit = 32;

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

    protected $appends = [
        'title',
    ];

    protected $withCount = [
        'books',
        'series',
    ];

    public function wikipediaConvert(WikipediaItem $item, bool $default = false): Wikipediable
    {
        $converter_engine = WikipediaItemConverter::make($item, $this)
            ->setWikipediaDescription()
        ;

        if (! $default) {
            $converter_engine->setWikipediaCover();
        }
        $this->save();

        return $this;
    }

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
        return $this->searchableNameAs();
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'cover' => $this->cover_thumbnail,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function setQueryAllowedFilters(): array
    {
        return [
            AllowedFilter::custom('q', new GlobalSearchFilter(['firstname', 'lastname', 'name'])),
            AllowedFilter::partial('firstname'),
            AllowedFilter::partial('lastname'),
            AllowedFilter::exact('role'),
        ];
    }

    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->name,
        );
    }
}
