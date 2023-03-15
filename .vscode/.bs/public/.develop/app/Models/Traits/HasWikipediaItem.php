<?php

namespace App\Models\Traits;

use App\Models\wikipedia_item;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait Haswikipedia_item
{
    public function wikipedia(): BelongsTo
    {
        return $this->belongsTo(wikipedia_item::class, 'wikipedia_item_id');
    }
}
