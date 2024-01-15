<?php

namespace App\Traits;

use App\Models\Language;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Manage language.
 *
 * - scope `whereLanguagesIs` with `whereIn` on `language_slug`
 * - relation `language` with `BelongsTo` `languages`
 */
trait HasLanguage
{
    public function scopeWhereLanguagesIs(Builder $query, ...$languages): Builder
    {
        // return $query->whereHas('language', function (Builder $query) use ($languages) {
        //     $query->whereIn('slug', $languages);
        // });

        return $query->whereIn('language_slug', $languages);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_slug');
    }
}
