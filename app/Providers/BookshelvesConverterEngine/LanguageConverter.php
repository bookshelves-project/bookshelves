<?php

namespace App\Providers\BookshelvesConverterEngine;

use App\Models\Language;
use App\Providers\EbookParserEngine\EbookParserEngine;

class LanguageConverter
{
    /**
     * Set Language from EbookParserEngine.
     */
    public static function create(EbookParserEngine $EPE): Language
    {
        $meta_name = $EPE->language;

        $available_langs = config('bookshelves.langs');
        if (array_key_exists($meta_name, $available_langs)) {
            $name = $available_langs[$meta_name];
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
