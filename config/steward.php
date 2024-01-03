<?php

use Kiwilan\Steward\Enums\Api\SeedsApiCategoryEnum;
use Kiwilan\Steward\Enums\Api\SeedsApiSizeEnum;
use Kiwilan\Steward\Enums\FactoryTextEnum;

return [
    /*
    |--------------------------------------------------------------------------
    | Steward Auth
    |--------------------------------------------------------------------------
    |
    | Auth config.
    |
    */

    'auth' => [
        'login_route' => 'login',
        'register_route' => 'register',
        'logout_route' => 'logout',
        'home_route' => 'home',
    ],

    /*
    /*
    |--------------------------------------------------------------------------
    | Steward mediable
    |--------------------------------------------------------------------------
    */

    'mediable' => [
        'default' => 'https://raw.githubusercontent.com/kiwilan/steward-laravel/main/public/no-image-available.jpg',
        'extensions' => ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'avif'],
        'format' => env('STEWARD_MEDIABLE_FORMAT', 'webp'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Steward template & builder
    |--------------------------------------------------------------------------
    |
    | To manage templates and builders.
    |
    */

    'template' => [
        'enum' => \Kiwilan\Steward\Enums\TemplateEnum::class,
    ],

    'builder' => [
        'enum' => \Kiwilan\Steward\Enums\BuilderEnum::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Steward submission
    |--------------------------------------------------------------------------
    |
    | To manage Submission model.
    |
    */

    'submission' => [
        'model' => \Kiwilan\Steward\Models\Submission::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | knuckleswtf/scribe
    |--------------------------------------------------------------------------
    |
    | To custom `knuckleswtf/scribe` package.
    |
    */

    'scribe' => [
        'endpoints' => [
            // 'book' => [
            //     'class' => \App\Models\Book::class,
            //     'routes' => ['books.show', 'books.update', 'books.destroy'],
            //     'field' => 'slug',
            // ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Steward filament
    |--------------------------------------------------------------------------
    |
    | To custom `filament/filament` package.
    |
    */

    'filament' => [
        'logo' => [
            'default' => env('FILAMENT_LOGO_DEFAULT', 'images/logo.svg'),
            'dark' => env('FILAMENT_LOGO_DARK', 'images/logo-dark.svg'),
        ],
        'logo-inline' => [
            'default' => env('FILAMENT_LOGO_INLINE_DEFAULT', 'images/logo-inline.svg'),
            'dark' => env('FILAMENT_LOGO_INLINE_DARK', 'images/logo-inline-dark.svg'),
        ],
        'widgets' => [
            'welcome' => [
                'url' => 'https://filamentphp.com/docs',
                'label' => 'filament::widgets/filament-info-widget.buttons.visit_documentation.label',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Steward query
    |--------------------------------------------------------------------------
    |
    | To manage `HttpQuery` and `Queryable` trait.
    |
    */

    'query' => [
        'default_sort' => 'id', // You could use any field name, reverse with `-id`
        'pagination' => 15,
        'no_paginate' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Steward HTTP
    |--------------------------------------------------------------------------
    |
    | To manage `HttpService`.
    |
    */

    'http' => [
        'pool_limit' => env('STEWARD_HTTP_POOL_LIMIT', 250),
        'async_allow' => env('STEWARD_HTTP_ASYNC_ALLOW', true),
    ],

    'iframely' => [
        'api' => env('STEWARD_IFRAMELY_API', 'https://iframely.com'),
        'key' => env('STEWARD_IFRAMELY_KEY', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Steward components
    |--------------------------------------------------------------------------
    |
    | To custom components.
    |
    */

    'components' => [
        'config' => [],
    ],

    'factory' => [
        'text' => FactoryTextEnum::lorem,
        'media_downloader' => [
            'default_category' => SeedsApiCategoryEnum::all,
            'default_size' => SeedsApiSizeEnum::medium,
            'seeds' => [
                'api' => 'https://seeds.git-projects.xyz',
            ],
        ],
        'max_handle' => env('STEWARD_FACTORY_MAX_HANDLE', 1000),
        'verbose' => env('STEWARD_FACTORY_VERBOSE', false),
    ],

    'gdpr' => [
        'service' => env('STEWARD_GDPR_SERVICE', 'orestbida/cookieconsent'), // https://github.com/orestbida/cookieconsent
        'cookie_name' => env('STEWARD_GDPR_COOKIE_NAME', 'cc_cookie'),
        'cookie_lifetime' => env('STEWARD_GDPR_COOKIE_LIFETIME', 182),
        'matomo' => [
            'enabled' => env('STEWARD_GDPR_MATOMO_ENABLED', true),
            'url' => env('STEWARD_GDPR_MATOMO_URL'),
            'site_id' => env('STEWARD_GDPR_MATOMO_SITE_ID'),
        ],
    ],

    'notify' => [
        'default' => env('STEWARD_NOTIFY_DEFAULT', 'discord'), // `discord`, `slack`
        'discord' => env('STEWARD_NOTIFY_DISCORD'), // STEWARD_NOTIFY_DISCORD=ID:TOKEN
        'slack' => env('STEWARD_NOTIFY_SLACK'), // STEWARD_NOTIFY_SLACK=ID:TOKEN:CHANNEL
    ],

    'livewire' => [
        'pagination' => [
            'theme' => 'tailwind',
            'default' => 20,
            'options' => [
                10,
                20,
                50,
                100,
            ],
        ],
    ],
];
