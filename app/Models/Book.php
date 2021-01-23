<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Book.
 *
 * @mixin \Eloquent
 *
 * @property int|null              $epub_id
 * @property \App\Models\Epub|null $epub
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereEpubId($value)
 *
 * @property int|null $publisher_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book wherePublisherId($value)
 *
 * @property int                             $id
 * @property string                          $title
 * @property string|null                     $slug
 * @property string|null                     $description
 * @property string|null                     $language
 * @property string|null                     $publish_date
 * @property string|null                     $isbn
 * @property \App\Models\Publisher|null      $publisher
 * @property string|null                     $cover
 * @property int|null                        $serie_id
 * @property int|null                        $serie_number
 * @property int|null                        $author_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\Author|null         $author
 * @property \App\Models\Serie|null          $serie
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book wherePublisher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSerieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSerieNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereUpdatedAt($value)
 *
 * @property string|null $language_slug
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereLanguageSlug($value)
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
        'slug',
        'description',
        'publish_date',
        'isbn',
        'serie_number',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function serie(): BelongsTo
    {
        return $this->belongsTo(Serie::class);
    }

    public function cover()
    {
        return $this->hasOne(Cover::class);
    }

    public function epub()
    {
        return $this->hasOne(Epub::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
