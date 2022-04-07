<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property null|\App\Models\User                         $user
 * @property \Eloquent|\Illuminate\Database\Eloquent\Model $reviewable
 */
class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'rating',
    ];

    protected $with = [
        'user',
        'reviewable',
    ];

    public function reviewable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function books()
    {
        return $this->morphedByMany(Book::class, 'reviewable', 'reviews', 'reviewable_id');
    }

    public function series()
    {
        return $this->morphedByMany(Serie::class, 'reviewable', 'reviews', 'reviewable_id');
    }

    public function authors()
    {
        return $this->morphedByMany(Author::class, 'reviewable', 'reviews', 'reviewable_id');
    }
}
