<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class HomePage extends Model
{
    use HasTranslations;

    public $translatable = [
        'label',
    ];
    protected $table = 'cms_home_page_statistics';
    protected $fillable = [
        'label',
        'count',
        'countWhere',
    ];
}
