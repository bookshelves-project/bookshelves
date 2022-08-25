<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ConverterEngine;
use App\Engines\ParserEngine;
use App\Models\Language;
use Locale;

class LanguageConverter
{
    /**
     * Set Language from ParserEngine.
     */
    public static function create(ConverterEngine $converter): Language
    {
        $lang_code = $converter->parser->language;

        if (! $converter->book->language) {
            $available_langs = config('bookshelves.langs');

            $language = Language::whereSlug($lang_code)->first();
            if (! $language) {
                $lang_names = [];
                foreach ($available_langs as $lang) {
                    $lang_names[$lang] = ucfirst(Locale::getDisplayLanguage($lang_code, $lang));
                }
                $language = Language::firstOrCreate([
                    'name' => $lang_names,
                    'slug' => $lang_code,
                ]);
            }

            $converter->book->language()->associate($language);
            $converter->book->save();

            return $language;
        }

        return $converter->book->language;
    }
}
