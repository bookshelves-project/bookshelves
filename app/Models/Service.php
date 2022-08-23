<?php

namespace App\Models;

use App\Enums\ColorEnum;
use App\Traits\HasBlocks;
use App\Traits\HasSEO;
use App\Traits\HasShowRoute;
use App\Traits\HasSlug;
use App\Traits\Mediable;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use HasFactory;
    use HasSlug;
    use HasSEO;
    use Mediable;
    use Sortable;
    use HasShowRoute;
    use HasBlocks;

    protected $fillable = [
        'title',
        'subtitle',

        'hang',
        'introduction',
        'title_after_purple_block',
        'cta_purple_block',

        'color',
        'cta',

        'body',

        'image',
        'image_extra',

        'alternate_blocks',
        'testimonies_blocks',

        'accordion_title',
        'accordion_image',
        'accordion_blocks',
    ];

    protected $casts = [
        'color' => ColorEnum::class,
        'alternate_blocks' => 'array',
        'testimonies_blocks' => 'array',
        'accordion_blocks' => 'array',
    ];

    protected $slug_with = 'title';
    protected $meta_title_from = 'title';
    protected $meta_description_from = 'hang';

    public function references(): BelongsToMany
    {
        return $this->belongsToMany(Reference::class);
    }
}
