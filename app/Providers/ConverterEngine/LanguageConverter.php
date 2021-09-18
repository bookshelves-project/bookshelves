<?php

namespace App\Providers\ConverterEngine;

use App\Models\Language;
use App\Providers\ParserEngine\ParserEngine;

class LanguageConverter
{
    /**
     * Set Language from ParserEngine.
     */
    public static function create(ParserEngine $parser): Language
    {
        $meta_name = $parser->language;

        $available_langs = config('bookshelves.langs');
        $langs = [];
        foreach ($available_langs as $lang) {
            $converted = explode('.', $lang);
            $langs[$converted[0]] = $converted[1];
        }
        if (array_key_exists($meta_name, $langs)) {
            $name = $langs[$meta_name];
        } else {
            $name = ucfirst($meta_name);
        }

        $lang = Language::firstOrCreate([
            'name' => $name,
            'slug' => $meta_name,
        ]);

        return $lang;
    }
}
