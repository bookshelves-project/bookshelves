<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kiwilan\Steward\Traits\HasSlug;

class Publisher extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'name',
    ];

    /**
     * Relationships.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class)
            ->orderBy('serie_id')
            ->orderBy('volume')
        ;
    }
}
