<?php

namespace App\Engines\Book\Converter\Modules;

use App\Models\Language;
use Kiwilan\Ebook\Ebook;
use Locale;

class LanguageConverter
{
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
