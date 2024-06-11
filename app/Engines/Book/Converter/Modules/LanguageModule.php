<?php

namespace App\Engines\Book\Converter\Modules;

use App\Models\Language;
use Locale;

class LanguageModule
{
    /**
     * Set Language from Ebook.
     */
    public static function make(?string $langCode): Language
    {
        if (! $langCode) {
            $langCode = 'en';
        }

        $language = Language::query()->where('slug', $langCode)->first();

        if (! $language) {
            $langName = ucfirst(Locale::getDisplayLanguage($langCode, 'en'));
            $language = Language::query()->firstOrCreate([
                'name' => $langName,
                'slug' => $langCode,
            ]);
        }

        return $language;
    }
}
