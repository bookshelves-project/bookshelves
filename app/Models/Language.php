<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Language
 *
 * @property string|null $slug
 * @property string|null $flag
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @method static \Illuminate\Database\Eloquent\Builder|Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereSlug($value)
 * @mixin \Eloquent
 */
class Language extends Model
{
    use HasFactory;

    protected $primaryKey = 'slug';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'slug',
        'flag',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
