<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\WikipediaItem.
 *
 * @property int                             $id
 * @property null|string                     $model
 * @property null|string                     $language
 * @property string                          $search_query
 * @property null|string                     $query_url
 * @property null|string                     $page_id
 * @property null|string                     $page_id_url
 * @property null|string                     $page_url
 * @property null|string                     $extract
 * @property null|string                     $picture_url
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property null|\App\Models\Author         $author
 * @property null|\App\Models\Serie          $serie
 *
 * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem whereExtract($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem wherePageIdUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem wherePageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem wherePictureUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem whereQueryUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem whereSearchQuery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WikipediaItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WikipediaItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'language',
        'search_query',
        'query_url',
        'page_id',
        'page_id_url',
        'page_url',
        'extract',
        'picture_url',
    ];

    public function author(): HasOne
    {
        return $this->hasOne(Author::class);
    }

    public function serie(): HasOne
    {
        return $this->hasOne(Serie::class);
    }
}
