<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Book.
 *
 * @property int                                                           $id
 * @property string                                                        $title
 * @property string|null                                                   $title_sort
 * @property string|null                                                   $slug
 * @property string|null                                                   $contributor
 * @property string|null                                                   $description
 * @property string|null                                                   $date
 * @property string|null                                                   $rights
 * @property int|null                                                      $serie_id
 * @property int|null                                                      $serie_number
 * @property int|null                                                      $cover_id
 * @property int|null                                                      $epub_id
 * @property int|null                                                      $publisher_id
 * @property string|null                                                   $language_slug
 * @property int|null                                                      $identifier_id
 * @property \Illuminate\Support\Carbon|null                               $created_at
 * @property \Illuminate\Support\Carbon|null                               $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Author[] $authors
 * @property int|null                                                      $authors_count
 * @property \App\Models\Cover|null                                        $cover
 * @property \App\Models\Epub|null                                         $epub
 * @property \App\Models\Author                                            $author
 * @property \App\Models\Epub|null                                         $identifier
 * @property \App\Models\Language|null                                     $language
 * @property \App\Models\Publisher|null                                    $publisher
 * @property \App\Models\Serie|null                                        $serie
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[]    $tags
 * @property int|null                                                      $tags_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereContributor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCoverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereEpubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIdentifierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereLanguageSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book wherePublisherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereRights($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSerieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSerieNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTitleSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Book extends Model
{
    use HasFactory;

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
        'serie_number',
    ];

    protected $with = [
        'language',
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function getAuthorAttribute(): Author
    {
        return $this->belongsToMany(Author::class)->first();
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function serie(): BelongsTo
    {
        return $this->belongsTo(Serie::class);
    }

    public function cover(): BelongsTo
    {
        return $this->belongsTo(Cover::class);
    }

    public function epub(): BelongsTo
    {
        return $this->belongsTo(Epub::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function identifier(): BelongsTo
    {
        return $this->belongsTo(Epub::class);
    }

    public function favorites()
    {
        return $this->morphToMany(User::class, 'favoritable');
    }
}
