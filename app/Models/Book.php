<?php

namespace App\Models;

use App\Models\Traits\HasAuthors;
use App\Models\Traits\HasClassName;
use App\Models\Traits\HasComments;
use App\Models\Traits\HasCovers;
use App\Models\Traits\HasFavorites;
use App\Models\Traits\HasLanguage;
use App\Models\Traits\HasSelections;
use App\Models\Traits\HasTagsAndGenres;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Tags\HasTags;

/**
 * App\Models\Book.
 *
 * @property int                                                                                                                           $id
 * @property string                                                                                                                        $title
 * @property null|string                                                                                                                   $title_sort
 * @property null|string                                                                                                                   $slug
 * @property null|string                                                                                                                   $contributor
 * @property null|string                                                                                                                   $description
 * @property null|string                                                                                                                   $date
 * @property null|string                                                                                                                   $rights
 * @property null|int                                                                                                                      $serie_id
 * @property null|int                                                                                                                      $volume
 * @property null|int                                                                                                                      $publisher_id
 * @property null|string                                                                                                                   $language_slug
 * @property null|int                                                                                                                      $identifier_id
 * @property null|int                                                                                                                      $google_book_id
 * @property null|int                                                                                                                      $page_count
 * @property null|string                                                                                                                   $maturity_rating
 * @property null|Carbon                                                                                                                   $created_at
 * @property null|Carbon                                                                                                                   $updated_at
 * @property \App\Models\Author[]|\Illuminate\Database\Eloquent\Collection                                                                 $authors
 * @property null|int                                                                                                                      $authors_count
 * @property \App\Models\Comment[]|\Illuminate\Database\Eloquent\Collection                                                                $comments
 * @property null|int                                                                                                                      $comments_count
 * @property \App\Models\User[]|\Illuminate\Database\Eloquent\Collection                                                                   $favorites
 * @property null|int                                                                                                                      $favorites_count
 * @property string                                                                                                                        $authors_names
 * @property null|string                                                                                                                   $cover_color
 * @property null|string                                                                                                                   $cover_og
 * @property null|string                                                                                                                   $cover_original
 * @property null|string                                                                                                                   $cover_simple
 * @property null|string                                                                                                                   $cover_thumbnail
 * @property string                                                                                                                        $download_link
 * @property null|string                                                                                                                   $epub
 * @property mixed                                                                                                                         $genres_list
 * @property bool                                                                                                                          $is_favorite
 * @property null|string                                                                                                                   $meta_author
 * @property string                                                                                                                        $show_link
 * @property string                                                                                                                        $show_link_opds
 * @property string                                                                                                                        $sort_name
 * @property mixed                                                                                                                         $tags_list
 * @property string                                                                                                                        $webreader_link
 * @property null|\App\Models\GoogleBook                                                                                                   $googleBook
 * @property null|\App\Models\Identifier                                                                                                   $identifier
 * @property null|\App\Models\Language                                                                                                     $language
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property null|int                                                                                                                      $media_count
 * @property null|\App\Models\Publisher                                                                                                    $publisher
 * @property \App\Models\User[]|\Illuminate\Database\Eloquent\Collection                                                                   $selections
 * @property null|int                                                                                                                      $selections_count
 * @property null|\App\Models\Serie                                                                                                        $serie
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[]                                                                   $tags
 * @property null|int                                                                                                                      $tags_count
 *
 * @method static \Database\Factories\BookFactory factory(...$parameters)
 * @method static Builder|Book newModelQuery()
 * @method static Builder|Book newQuery()
 * @method static Builder|Book publishedBetween(string $startDate, string $endDate)
 * @method static Builder|Book query()
 * @method static Builder|Book whereAllowSerie(string $has_serie)
 * @method static Builder|Book whereAuthorIsLike(string $author)
 * @method static Builder|Book whereContributor($value)
 * @method static Builder|Book whereCreatedAt($value)
 * @method static Builder|Book whereDate($value)
 * @method static Builder|Book whereDescription($value)
 * @method static Builder|Book whereGoogleBookId($value)
 * @method static Builder|Book whereId($value)
 * @method static Builder|Book whereIdentifierId($value)
 * @method static Builder|Book whereLanguageSlug($value)
 * @method static Builder|Book whereLanguagesIs($languages)
 * @method static Builder|Book whereMaturityRating($value)
 * @method static Builder|Book wherePageCount($value)
 * @method static Builder|Book wherePublisherId($value)
 * @method static Builder|Book whereRights($value)
 * @method static Builder|Book whereSerieId($value)
 * @method static Builder|Book whereSerieTitleIs($title)
 * @method static Builder|Book whereSlug($value)
 * @method static Builder|Book whereTagsAllIs($tags)
 * @method static Builder|Book whereTagsIs($tags)
 * @method static Builder|Book whereTitle($value)
 * @method static Builder|Book whereTitleSort($value)
 * @method static Builder|Book whereUpdatedAt($value)
 * @method static Builder|Book whereVolume($value)
 * @method static Builder|Book withAllTags(array|\ArrayAccess|\Spatie\Tags\Tag $tags, ?string $type = null)
 * @method static Builder|Book withAllTagsOfAnyType($tags)
 * @method static Builder|Book withAnyTags(array|\ArrayAccess|\Spatie\Tags\Tag $tags, ?string $type = null)
 * @method static Builder|Book withAnyTagsOfAnyType($tags)
 * @mixin \Eloquent
 */
class Book extends Model implements HasMedia
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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'title_sort',
        'slug',
        'contributor',
        'description',
        'date',
        'rights',
        'volume',
        'page_count',
        'maturity_rating',
    ];

    protected $with = [
        'language',
        'authors',
        'media',
    ];

    /**
     * Retrieve the model for a bound value.
     *
     * @param mixed       $value
     * @param null|string $field
     *
     * @return null|\Illuminate\Database\Eloquent\Model
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('slug', $value)->with('media')->firstOrFail();
    }

    /**
     * Manage EPUB files with spatie/laravel-medialibrary.
     */
    public function getEpubAttribute(): string|null
    {
        return $this->getFirstMediaUrl('epubs');
    }

    public function getEpubPathAttribute(): string|null
    {
        $path = $this->getFirstMediaPath('epubs');
        $path = explode('/storage/app/public', $path);
        if (array_key_exists(1, $path)) {
            $path = $path[1];
        }
        $full = config('app.url').'/storage'.$path;
        return $full;
    }

    public function scopeWhereDisallowSerie(Builder $query, string $has_not_serie): Builder
    {
        $has_not_serie = filter_var($has_not_serie, FILTER_VALIDATE_BOOLEAN);

        return $has_not_serie ? $query->whereDoesntHave('serie') : $query;
    }

    public function scopePublishedBetween(Builder $query, string $startDate, string $endDate): Builder
    {
        return $query
            ->whereBetween('date', [Carbon::parse($startDate), Carbon::parse($endDate)])
        ;
    }

    /**
     * Define sort name for `/api/books` with serie-volume-book.
     */
    public function getSortNameAttribute(): string
    {
        $serie = null;
        if ($this->serie) {
            // @phpstan-ignore-next-line
            $volume = strlen($this->volume) < 2 ? '0'.$this->volume : $this->volume;
            $serie = $this->serie->title_sort.' '.$volume;
            $serie = Str::slug($serie).'_';
        }
        $title = Str::slug($this->title_sort);

        return "{$serie}{$title}";
    }

    public function scopeWhereSerieTitleIs(Builder $query, $title): Builder
    {
        return $query
            ->whereRelation('serie', 'title', '=', $title)
        ;
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'picture' => $this->cover_thumbnail,
            'date' => $this->date,
            'author' => $this->authors_names,
            'isbn' => $this->identifier->isbn ?? null,
            'isbn13' => $this->identifier->isbn13 ?? null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function serie(): BelongsTo
    {
        return $this->belongsTo(Serie::class);
    }

    public function identifier(): BelongsTo
    {
        return $this->belongsTo(Identifier::class);
    }

    public function googleBook(): BelongsTo
    {
        return $this->belongsTo(GoogleBook::class);
    }
}
