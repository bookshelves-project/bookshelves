<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
