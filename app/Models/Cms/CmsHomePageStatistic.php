<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Cms\CmsHomePageStatistic.
 *
 * @property int                              $id
 * @property null|array                       $label
 * @property null|string                      $link
 * @property null|string                      $model
 * @property null|array                       $modelWhere
 * @property null|int                         $cms_home_page_id
 * @property null|\Illuminate\Support\Carbon  $created_at
 * @property null|\Illuminate\Support\Carbon  $updated_at
 * @property int                              $count
 * @property array                            $translations
 * @property null|\App\Models\Cms\CmsHomePage $homePage
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageStatistic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageStatistic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageStatistic query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageStatistic whereCmsHomePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageStatistic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageStatistic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageStatistic whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageStatistic whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageStatistic whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageStatistic whereModelWhere($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsHomePageStatistic whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
