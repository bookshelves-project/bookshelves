<?php

namespace App\Engines\Converter\Modules;

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

        /** @var ?Language $language */
        $language = Language::query()->where('slug', $langCode)->first();

        if (! $language) {
            $language = Language::query()->where('name', $langCode)->first();
        }

        if (! $language) {
            $self = new self;
            $language = $self->createLang($langCode);
        }

        return $language;
    }

    private function createLang(string $langCode): Language
    {
        $langName = ucfirst(Locale::getDisplayLanguage($langCode, 'en'));

        return Language::query()->firstOrCreate([
            'name' => $langName,
            'slug' => $langCode,
        ]);
    }
}
