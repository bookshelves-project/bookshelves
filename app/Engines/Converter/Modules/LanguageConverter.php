<?php

namespace App\Engines\Converter\Modules;

use App\Engines\Parser\Models\BookEntity;
use App\Models\Language;
use Locale;

class LanguageConverter
{
    /**
     * Set Language from BookEntity.
     */
    public static function toModel(BookEntity $entity): Language
    {
        $availableLangs = config('bookshelves.langs');
        $langCode = $entity->language();

        $language = Language::whereSlug($langCode)->first();

        if (! $language) {
            $langNames = [];

            foreach ($availableLangs as $lang) {
                $langNames[$lang] = ucfirst(Locale::getDisplayLanguage($langCode, $lang));
            }
            $language = Language::firstOrCreate([
                'name' => $langNames,
                'slug' => $langCode,
            ]);
        }

        return $language;
    }
}
