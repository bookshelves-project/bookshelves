<?php

namespace App\Engines\Book\Converter\Modules;

use App\Models\Language;
use Kiwilan\Ebook\Ebook;
use Locale;

class LanguageConverter
{
    public static function make(?string $language): ?Language
    {
        $availableLangs = config('bookshelves.langs');
        $langCode = $language ?? 'en';

        if (! $language) {
            return null;
        }

        $langNames = [];

        foreach ($availableLangs as $lang) {
            $langNames[$lang] = ucfirst(Locale::getDisplayLanguage($langCode, $lang));
        }

        return new Language([
            'name' => $langNames,
            'slug' => $langCode,
        ]);
    }

    /**
     * Set Language from Ebook.
     */
    public static function toModel(Ebook $ebook): Language
    {
        $availableLangs = config('bookshelves.langs');
        $langCode = $ebook->language() ?? 'en';

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
