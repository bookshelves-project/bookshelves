<?php

namespace App\Models\Traits;

use App\Models\Language;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Manage language with `BelongsTo` `languages`.
 */
trait HasLanguage
{
    public function scopeWhereLanguagesIs(Builder $query, ...$languages)
    {
        if ('any' === $languages[0]) {
            return $query;
        }

        return $query->whereHas('language', function (Builder $query) use ($languages) {
            $query->whereIn('slug', $languages, 'and', false);
        });
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
