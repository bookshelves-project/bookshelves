<?php

namespace App\Models\Cms;

use App\Enums\NavigationCategoryEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Navigation extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = [
        'title',
    ];

    public $timestamps = false;

    protected $table = 'cms_navigations';

    protected $fillable = [
        'title',
        'route',
        'category',
    ];

    protected $casts = [
        'category' => NavigationCategoryEnum::class,
    ];
}
