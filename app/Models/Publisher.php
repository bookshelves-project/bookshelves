<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Publisher extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'slug',
    ];

    public function getShowLinkAttribute(): string
    {
        $route = route('api.publishers.show', [
            'publisher' => $this->slug,
        ]);

        return $route;
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class)->orderBy('serie_id')->orderBy('volume');
    }
}
