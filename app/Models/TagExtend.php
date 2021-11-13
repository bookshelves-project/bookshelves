<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;
use Spatie\Tags\Tag;

class TagExtend extends Tag
{
    protected $table = 'tags';

    protected $appends = [
        'first_char',
    ];

    public function getFirstCharAttribute()
    {
        return strtoupper(substr(Str::slug($this->name), 0, 1));
    }

    public function books(): MorphToMany
    {
        return $this->morphToMany(
            related: Book::class,
            name: 'taggable',
            table: 'taggables',
            foreignPivotKey: 'tag_id',
            relatedPivotKey: 'taggable_id',
            parentKey: 'id',
            relatedKey: 'id',
            inverse: true
        );
    }
}
