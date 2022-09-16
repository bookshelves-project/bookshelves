<?php

namespace App\Models;

use App\Enums\BuilderEnum;
use Illuminate\Database\Eloquent\Model;
use Kiwilan\Steward\Enums\LanguageEnum;
use Kiwilan\Steward\Traits\HasBuilder;
use Kiwilan\Steward\Traits\HasSeo;
use Kiwilan\Steward\Traits\HasSlug;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasSlug;
    // use HasShowRoute;
    use HasBuilder;
    use HasSeo;

    protected $fillable = [
        'title',
        'language',
        'content',
    ];

    protected $casts = [
        'content' => 'array',
        'language' => LanguageEnum::class,
        'builder' => BuilderEnum::class,
    ];
}
