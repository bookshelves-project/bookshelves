<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'slug';

    protected $keyType = 'string';

    protected $fillable = [
        'slug',
        'name',
    ];

    /**
     * Relationships
     */

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function series(): HasMany
    {
        return $this->hasMany(Serie::class);
    }
}
