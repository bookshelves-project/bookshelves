<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

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
            ->doNotGenerateSlugsOnUpdate();
    }
}
