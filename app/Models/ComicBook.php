<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ComicBook.
 *
 * @property int                             $id
 * @property string                          $title
 * @property null|string                     $title_sort
 * @property null|string                     $slug
 * @property null|string                     $description
 * @property null|string                     $date
 * @property null|string                     $rights
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 *
 * @method static \Database\Factories\ComicBookFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ComicBook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ComicBook newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ComicBook query()
 * @method static \Illuminate\Database\Eloquent\Builder|ComicBook whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComicBook whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComicBook whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComicBook whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComicBook whereRights($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComicBook whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComicBook whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComicBook whereTitleSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComicBook whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ComicBook extends Model
{
    use HasFactory;
}
