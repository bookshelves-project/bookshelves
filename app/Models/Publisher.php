<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Publisher extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'slug',
    ];

    protected $appends = [
        'first_char',
    ];

    public function getFirstCharAttribute()
    {
        return strtoupper(substr(Str::slug($this->name), 0, 1));
    }

    public function getShowLinkAttribute(): string
    {
        return route('api.publishers.show', [
            'publisher' => $this->slug,
        ]);
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class)->orderBy('serie_id')->orderBy('volume');
    }
}
