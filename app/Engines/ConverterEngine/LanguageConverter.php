<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ParserEngine;
use App\Models\Book;
use App\Models\Language;

class LanguageConverter
{
    /**
     * Set Language from ParserEngine.
     */
    public static function create(ParserEngine $parser, Book $book): Language
    {
        $meta_name = $parser->language;

        if (! $book->language) {
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
            $language = Language::firstOrCreate([
                'name' => $name,
                'slug' => $meta_name,
            ]);

            $book->language()->associate($language);

            return $language;
        }

        return $book->language;
    }
}
