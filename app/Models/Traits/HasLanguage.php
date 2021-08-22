<?php

namespace App\Models\Traits;

use App\Models\Language;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Manage language with `BelongsTo` `languages`
 */
trait HasLanguage
{
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
