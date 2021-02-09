<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Author.
 *
 * @property int                                                         $id
 * @property string|null                                                 $name
 * @property string|null                                                 $slug
 * @property \Illuminate\Support\Carbon|null                             $created_at
 * @property \Illuminate\Support\Carbon|null                             $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property int|null                                                    $books_count
 * @method static \Illuminate\Database\Eloquent\Builder|Author newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Author newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Author query()
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $lastname
 * @property string|null $firstname
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereLastname($value)
 * @property string|null $picture
 * @method static \Illuminate\Database\Eloquent\Builder|Author wherePicture($value)
 */
class Author extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'lastname',
        'firstname',
        'name',
        'slug',
        'picture',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class)->with('epub')->orderBy('serie_id')->orderBy('serie_number');
    }
}
