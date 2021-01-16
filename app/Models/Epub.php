<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Epub.
 *
 * @property int                             $id
 * @property string|null                     $epub_name
 * @property string|null                     $epub_path
 * @property string|null                     $epub_size
 * @property int|null                        $book_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\Book|null           $epub
 * @method static \Illuminate\Database\Eloquent\Builder|Epub newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Epub newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Epub query()
 * @method static \Illuminate\Database\Eloquent\Builder|Epub whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Epub whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Epub whereEpubName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Epub whereEpubPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Epub whereEpubSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Epub whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Epub whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $name
 * @property string|null $path
 * @property string|null $size
 * @method static \Illuminate\Database\Eloquent\Builder|Epub whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Epub wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Epub whereSize($value)
 * @property-read \App\Models\Book|null $book
 */
class Epub extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'size',
    ];

    public function book()
    {
        return $this->hasOne(Book::class);
    }
}
