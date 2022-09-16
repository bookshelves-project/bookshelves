<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Kiwilan\Steward\Enums\PublishStatusEnum;

trait Publishable
{
    public function initializePublishable()
    {
        $this->fillable[] = 'status';
        $this->fillable[] = 'published_at';

        $this->casts['status'] = PublishStatusEnum::class;
        $this->casts['published_at'] = 'datetime:Y-m-d';
    }

    public function scopePublished(Builder $builder)
    {
        return $builder
            ->where('status', PublishStatusEnum::published)
            ->where('published_at', '<=', Carbon::now())
            ->orderBy('published_at', 'desc')
        ;
    }
}
