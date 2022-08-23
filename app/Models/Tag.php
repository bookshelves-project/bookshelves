<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $withCount = [
        'posts',
    ];

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }
}
