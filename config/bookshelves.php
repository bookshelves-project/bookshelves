<?php

use Illuminate\Support\Str;

return [
    'slug' => Str::slug(env('APP_NAME', 'Bookshelves')),
    'repository_url' => env('BOOKSHELVES_REPOSITORY_URL', 'https://github.com/bookshelves-project'),
    'documentation_url' => env('BOOKSHELVES_DOCUMENTATION_URL', 'https://bookshelves-documentation.netlify.app'),
    // General.
    'cover_extension' => env('BOOKSHELVES_COVER_FORMAT', 'webp'),
    // Authors.
    'authors' => [
        // Depends of your order of sort for authors
        // true: `Victor Hugo` will be `firstname`: "Victor", `lastname`: "Hugo"
        // false: `Hugo Victor` will be `firstname`: "Victor", `lastname`: "Hugo"
        'order_natural' => env('BOOKSHELVES_AUTHOR_ORDER_NATURAL', true),
        // true: `Victor Hugo` and `Hugo Victor` will be merge
        // false: two Author will be created
        'detect_homonyms' => env('BOOKSHELVES_AUTHOR_DETECT_HOMONYMS', true),
    ],
    'parser' => [
        'name' => env('BOOKSHELVES_PARSER_NAME', true),
    ],
    'pdf' => [
        'cover' => env('BOOKSHELVES_PDF_COVER', true),
        'metadata' => env('BOOKSHELVES_PDF_METADATA', true),
    ],
    /*
     * Langs
     * ParserEngine will create Language with translations from Locale
     */
    'langs' => explode(',', env('BOOKSHELVES_LANGS', 'fr,en')),
    /*
     * Tags
     * From Wikipedia: https://en.wikipedia.org/wiki/List_of_writing_genres.
     * Any tag add here will be used as 'genre'.
     */
    'tags' => [
        'genres_list' => explode(',', env('BOOKSHELVES_TAGS_GENRES', 'Action & adventures,Crime & mystery,Fantasy,Horror,Romance,Science fiction')),
        'forbidden' => explode(',', env('BOOKSHELVES_TAGS_FORBIDDEN', 'SF,General')),
        'converted' => [
            'Action & Adventure' => 'Action & adventures',
        ],
    ],
];
