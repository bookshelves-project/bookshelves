<?php

namespace App\Engines\ConverterEngine\Modules;

use App\Engines\ConverterEngine;
use App\Engines\ConverterEngine\Modules\Interface\ConverterInterface;
use App\Engines\ParserEngine;
use App\Models\Language;
use Locale;

class LanguageConverter implements ConverterInterface
{
    /**
     * Set Language from ParserEngine.
     */
    public static function make(ConverterEngine $converter_engine): Language
    {
        $lang_code = $converter_engine->parser_engine->language;

        if (! $converter_engine->book->language) {
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

            $converter_engine->book->language()->associate($language);
            $converter_engine->book->save();

            return $language;
        }

        return $converter_engine->book->language;
    }
}
