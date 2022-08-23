<?php

namespace App\Models;

use App\Traits\HasBlocks;
use App\Traits\HasSEO;
use App\Traits\HasShowLive;
use App\Traits\HasShowRoute;
use App\Traits\HasSlug;
use App\Traits\Mediable;
use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reference extends Model
{
    use HasFactory;
    use HasSlug;
    use HasShowLive;
    use HasSEO;
    use Mediable;
    use Publishable;
    use HasShowRoute;
    use HasBlocks;

    protected $fillable = [
        'title',
        'summary',

        'site_url',
        'image',
        'cta',

        'presentation_title',
        'presentation_text',
        'presentation_year',

        'testimony_title',
        'testimony_text',
        'testimony_image',

        'alternate_blocks',
    ];

    protected $slug_with = 'title';
    protected $show_live_endpoint = 'realisations';
    protected $meta_title_from = 'title';
    protected $meta_description_from = 'summary';

    protected $casts = [
        'alternate_blocks' => 'array',
    ];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ReferenceCategory::class, 'reference_category_id');
    }
}
