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
        'default_sort' => 'id',
        'default_sort_direction' => 'asc',
        'limit' => 15,
        'full' => false,
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
        'pool_limit' => env('STEWARD_HTTP_POOL_LIMIT', 200),
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
    ],
];
