<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Cover.
 *
 * @property int                   $id
 * @property string|null           $name
 * @property int|null              $book_id
 * @property \App\Models\Book|null $book
 * @property mixed                 $basic
 * @property mixed                 $original
 * @property mixed                 $thumbnail
 * @method static \Illuminate\Database\Eloquent\Builder|Cover newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cover newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cover query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cover whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cover whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cover whereName($value)
 * @mixin \Eloquent
 */
class Cover extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
    ];

    public function getOriginalAttribute()
    {
        return config('app.url').'/storage/covers-original/'.$this->name.'.jpg';
    }

    public function getThumbnailAttribute()
    {
        return config('app.url').'/storage/cache/'.$this->name.'.jpg';
    }

    public function getBasicAttribute()
    {
        return config('app.url').'/storage/covers-basic/'.$this->name.'.jpg';
    }

    public function book()
    {
        return $this->hasOne(Book::class);
    }
}
