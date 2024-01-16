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
        $langCode = $ebook->getLanguage() ?? 'en';
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
