<?php

namespace App\Models\Traits;

use App\Models\WikipediaItem;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasWikipediaItem
{
    public function wikipedia(): BelongsTo
    {
        return $this->belongsTo(WikipediaItem::class, 'wikipedia_item_id');
    }
}
