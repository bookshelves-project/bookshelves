<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Book.
 *
 * @property int                             $id
 * @property string                          $title
 * @property string|null                     $slug
 * @property string|null                     $description
 * @property string|null                     $language
 * @property string|null                     $publish_date
 * @property string|null                     $isbn
 * @property string|null                     $publisher
 * @property string|null                     $cover_path
 * @property string|null                     $epub_path
 * @property int|null                        $serie_id
 * @property int|null                        $serie_number
 * @property int|null                        $author_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\Author|null         $author
 * @property \App\Models\Serie|null          $serie
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCoverPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereEpubPath($value)
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
 * @mixin \Eloquent
 * @property int|null $epub_id
 * @property-read \App\Models\Epub|null $epub
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereEpubId($value)
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
        'author',
        'description',
        'language',
        'publish_date',
        'isbn',
        'publisher',
        'cover_path',
        'serie_number',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function serie(): BelongsTo
    {
        return $this->belongsTo(Serie::class);
    }

    public function epub()
    {
        return $this->hasOne(Epub::class);
    }
}
