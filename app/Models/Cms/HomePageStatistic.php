<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property null|string $model
 * @property null|int    $count
 * @property null|array  $label
 * @property null|array  $modelWhere
 */
class HomePageStatistic extends Model
{
    use HasTranslations;

    public $translatable = [
        'label',
    ];
    protected $table = 'cms_home_page_statistics';
    protected $fillable = [
        'label',
        'model',
        'modelWhere',
    ];

    public function getCount(): int
    {
        /** @var HomePageStatistic $statistic */
        $statistic = $this;

        $count = 0;
        $class = $statistic->model;

        if ($statistic->modelWhere) {
            $count = $class::where($statistic->modelWhere[0], $statistic->modelWhere[1])
                ->count()
            ;
        } else {
            $count = $class::count();
        }

        return $count;
    }
}
