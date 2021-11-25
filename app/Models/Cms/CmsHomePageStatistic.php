<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CmsHomePageStatistic extends Model
{
    use HasTranslations;

    public $translatable = [
        'label',
    ];
    protected $fillable = [
        'label',
        'link',
        'model',
        'modelWhere',
    ];
    protected $casts = [
        'modelWhere' => 'array',
    ];
    protected $appends = [
        'count',
    ];

    public function getCountAttribute(): int
    {
        $count = 0;
        $class = $this->model;

        if ($this->modelWhere) {
            $count = $class::where($this->modelWhere[0], $this->modelWhere[1])
                ->count()
            ;
        } else {
            $count = $class::count();
        }

        return $count;
    }

    public function homePage()
    {
        return $this->belongsTo(CmsHomePage::class, 'cms_home_page_id');
    }
}
