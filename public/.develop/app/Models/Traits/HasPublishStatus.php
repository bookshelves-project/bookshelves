<?php

namespace App\Models\Traits;

use App\Enums\PostStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

trait HasPublishStatus
{
    public function scopeDraft(Builder $query)
    {
        return $query->whereStatus(PostStatusEnum::draft);
    }

    public function scopeScheduled(Builder $query)
    {
        return $query->whereStatus(PostStatusEnum::scheduled);
    }

    public function scopePublished(Builder $query)
    {
        return $query->whereStatus(PostStatusEnum::published);
    }

    public function scopePublishedBetween(Builder $query, $startDate, $endDate)
    {
        return $query
            ->whereBetween('published_at', [Carbon::parse($startDate), Carbon::parse($endDate)])
        ;
    }
}
