<?php

namespace App\Models;

use App\Enums\LanguageEnum;
use App\Traits\HasSeo;
use App\Traits\HasShowRoute;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Kiwilan\Steward\Traits\HasBuilder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasSlug;
    // use HasShowRoute;
    use HasBuilder;
    use HasSeo;

    protected $table = 'cms_pages';

    protected $fillable = [
        'title',
        'language',
        'content',
    ];

    protected $casts = [
        'content' => 'array',
        'language' => LanguageEnum::class,
    ];
}
