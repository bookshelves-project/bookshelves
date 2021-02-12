<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'rating',
    ];

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
