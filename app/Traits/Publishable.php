<?php

namespace App\Traits;

use App\Enums\PublishStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

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
