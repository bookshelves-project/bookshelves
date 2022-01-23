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
            'title' => env('APP_NAME', false), // set false to total remove
            'titleBefore' => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description' => 'Bookshelves, to read Ebooks.', // set false to total remove
            'separator' => ' - ',
            'keywords' => [],
            'canonical' => null, // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots' => false, // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
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
            'title' => env('APP_NAME', false), // set false to total remove
            'description' => 'Bookshelves, to read Ebooks.', // set false to total remove
            'url' => false, // Set null for using Url::current(), set false to total remove
            'type' => false,
            'site_name' => false,
            'images' => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card' => 'summary_large_image',
            'creator' => '@ewilanriviere',
            'site' => '@ewilanriviere',
            'url' => 'https://twitter.com/ewilanriviere',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title' => env('APP_NAME', false), // set false to total remove
            'description' => 'Bookshelves, to read Ebooks.', // set false to total remove
            'url' => false, // Set null for using Url::current(), set false to total remove
            'type' => 'WebPage',
            'images' => [],
        ],
    ],
];
