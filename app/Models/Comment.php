<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Comment.
 *
 * @property int                                                           $id
 * @property string|null                                                   $text
 * @property int|null                                                      $rating
 * @property \Illuminate\Support\Carbon|null                               $created_at
 * @property \Illuminate\Support\Carbon|null                               $updated_at
 * @property int|null                                                      $user_id
 * @property int|null                                                      $commentable_id
 * @property string|null                                                   $commentable_type
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Author[] $authors
 * @property int|null                                                      $authors_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Book[]   $books
 * @property int|null                                                      $books_count
 * @property Model|\Eloquent                                               $commentable
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Serie[]  $series
 * @property int|null                                                      $series_count
 * @property \App\Models\User|null                                         $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUserId($value)
 * @mixin \Eloquent
 *
 * @method static \Database\Factories\CommentFactory factory(...$parameters)
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'rating',
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function books()
    {
        return $this->morphedByMany(Book::class, 'commentable');
    }

    public function series()
    {
        return $this->morphedByMany(Serie::class, 'commentable');
    }

    public function authors()
    {
        return $this->morphedByMany(Author::class, 'commentable');
    }
}
