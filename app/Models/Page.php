<?php

namespace App\Models;

use App\Enums\TemplateEnum;
use Illuminate\Database\Eloquent\Model;
use Kiwilan\Steward\Enums\LanguageEnum;
use Kiwilan\Steward\Traits\HasSeo;
use Kiwilan\Steward\Traits\HasShowRoute;
use Kiwilan\Steward\Traits\HasSlug;
use Kiwilan\Steward\Traits\HasTemplate;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasSlug;
    use HasShowRoute;
    use HasTemplate;
    use HasSeo;

    protected $slug_with = 'title';

    protected $fillable = [
        'title',
        'language',
    ];

    protected $casts = [
        'language' => LanguageEnum::class,
        'template' => TemplateEnum::class, // TODO steward config
    ];
}
