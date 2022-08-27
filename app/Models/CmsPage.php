<?php

namespace App\Models;

use App\Traits\HasSeo;
use App\Traits\HasShowRoute;
use App\Traits\HasTemplate;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CmsPage extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasShowRoute;
    use HasTemplate;
    use HasSeo;

    protected $table = 'cms_pages';

    protected $fillable = [
        'title',
        'language',
        'content',
    ];

    protected $casts = [
        'content' => 'array',
    ];
}
