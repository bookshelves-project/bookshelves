<?php

namespace App\Models;

use App\Traits\HasSeo;
use App\Traits\HasSlug;
use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    use Publishable;
    use HasSeo;
    use HasSlug;

    protected $fillable = [
        'title',
        'summary',
        'body',
    ];

    protected $slug_with = 'title';
}
