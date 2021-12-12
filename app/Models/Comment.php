<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Comment.
 *
 * @property int                                                           $id
 * @property null|string                                                   $text
 * @property null|int                                                      $rating
 * @property null|int                                                      $user_id
 * @property null|int                                                      $commentable_id
 * @property null|string                                                   $commentable_type
 * @property null|\Illuminate\Support\Carbon                               $created_at
 * @property null|\Illuminate\Support\Carbon                               $updated_at
 * @property \App\Models\Author[]|\Illuminate\Database\Eloquent\Collection $authors
 * @property null|int                                                      $authors_count
 * @property \App\Models\Book[]|\Illuminate\Database\Eloquent\Collection   $books
 * @property null|int                                                      $books_count
 * @property \Eloquent|Model                                               $commentable
 * @property \App\Models\Serie[]|\Illuminate\Database\Eloquent\Collection  $series
 * @property null|int                                                      $series_count
 * @property null|\App\Models\User                                         $user
 *
 * @method static \Database\Factories\CommentFactory factory(...$parameters)
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
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'rating',
    ];

    protected $with = [
        'user',
        'commentable',
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
        return $this->morphedByMany(Book::class, 'commentable', 'comments', 'commentable_id');
    }

    public function series()
    {
        return $this->morphedByMany(Serie::class, 'commentable', 'comments', 'commentable_id');
    }

    public function authors()
    {
        return $this->morphedByMany(Author::class, 'commentable', 'comments', 'commentable_id');
    }
}
