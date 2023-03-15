<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults' => [
            'title' => env('META_TITLE', 'Bookshelves'), // set false to total remove
            'titleBefore' => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description' => env('META_DESCRIPTION', 'To read books.'), // set false to total remove
            'separator' => ' · ',
            'keywords' => [],
            'canonical' => 'full', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots' => env('META_ROBOTS', 'all'), // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google' => null,
            'bing' => null,
            'alexa' => null,
            'pinterest' => null,
            'yandex' => null,
            'norton' => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title' => env('META_OG_TITLE', 'Bookshelves'), // set false to total remove
            'description' => env('META_OG_DESCRIPTION', 'To read books.'), // set false to total remove
            'url' => 'full', // Set null for using Url::current(), set false to total remove
            'type' => false,
            'site_name' => false,
            'images' => [
                '/default.jpg',
            ],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card' => 'summary_large_image',
            // 'site'        => '@LuizVinicius73',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title' => env('META_TITLE', 'Bookshelves'), // set false to total remove
            'description' => env('META_DESCRIPTION', 'To read books.'), // set false to total remove
            'url' => 'full', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'type' => 'WebPage',
            'images' => [],
        ],
    ],
];
