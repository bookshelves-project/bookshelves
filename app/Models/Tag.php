<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'slug',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }
}
