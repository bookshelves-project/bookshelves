<?php

namespace App\Models;

use App\Models\Traits\HasFirstChar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    use HasFirstChar;

    public $incrementing = false;
    public $timestamps = false;

    protected $primaryKey = 'slug';
    protected $keyType = 'string';
    protected $fillable = [
        'slug',
        'name',
    ];

    protected $withCount = [
        'books',
    ];
    protected $appends = [
        'first_char',
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
