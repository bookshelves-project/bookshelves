<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'slug';
    protected $keyType = 'string';
    protected $fillable = [
        'slug',
        'name',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function series(): HasMany
    {
        return $this->hasMany(Serie::class);
    }
}
