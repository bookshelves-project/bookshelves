<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostCategory extends Model implements Sortable
{
    use HasFactory;
    use HasSlug;
    use SortableTrait;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $hidden = [
        'order_column',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate()
        ;
    }
}
