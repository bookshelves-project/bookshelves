<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Cover
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $extension
 * @property-read \App\Models\Book|null $book
 * @property-read mixed $basic
 * @property-read mixed $original
 * @property-read mixed $thumbnail
 * @method static \Illuminate\Database\Eloquent\Builder|Cover newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cover newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cover query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cover whereExtension($value)
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
        'extension',
    ];

    public function getOriginalAttribute()
    {
        return config('app.url').'/storage/covers/original/'.$this->name.$this->extension;
    }

    public function getThumbnailAttribute()
    {
        return config('app.url').'/storage/covers/thumbnail/'.$this->name.$this->extension;
    }

    public function getBasicAttribute()
    {
        return config('app.url').'/storage/covers/basic/'.$this->name.$this->extension;
    }

    public function book(): HasOne
    {
        return $this->hasOne(Book::class);
    }
}
