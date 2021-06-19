<?php

namespace App\Models;

use Spatie\Tags\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class TagExtend extends Tag
{
    protected $table = 'tags';

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
