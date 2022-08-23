<?php

namespace App\Models;

use App\Traits\HasSEO;
use App\Traits\HasShowLive;
use App\Traits\HasShowRoute;
use App\Traits\HasSlug;
use App\Traits\Mediable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    use HasSlug;
    use HasShowLive;
    use HasSEO;
    use HasShowRoute;
    use Mediable;

    protected $fillable = [
        'title',
        'summary',
        'body',
        'image',
    ];

    protected $slug_with = 'title';
    protected $show_live_endpoint = 'pages';
    protected $meta_title_from = 'title';
    protected $meta_description_from = 'summary';
}
