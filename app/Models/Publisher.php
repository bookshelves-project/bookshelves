<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Publisher extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'name',
    ];


    /**
     * Relationships
     */

    public function books(): HasMany
    {
        return $this->hasMany(Book::class)
            ->orderBy('serie_id')
            ->orderBy('volume');
    }
}
