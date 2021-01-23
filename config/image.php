<?php

return [
    /*
  |--------------------------------------------------------------------------
  | Image Driver
  |--------------------------------------------------------------------------
  |
  | Intervention Image supports "GD Library" and "Imagick" to process images
  | internally. You may choose one of them according to your PHP
  | configuration. By default PHP's "GD Library" implementation is used.
  |
  | Supported: "gd", "imagick"
  |
  */

    'driver' => 'gd',

    'thumbnails' => [
        // Classic
        'admin_preview' => [
            'width'  => 200,
            'height' => 200,
        ],
        'small' => [
            'width'  => 400,
            'height' => 400,
        ],
        'medium' => [
            'width'  => 900,
            'height' => 900,
        ],
        'large' => [
            'width'  => 1800,
            'height' => 1800,
        ],

        // Custom sizes
        'book_cover' => [
            'width'  => 480,
            'height' => 640,
        ],
        'book_thumbnail' => [
            'width'  => 240,
            'height' => 320,
        ],
        'avatar' => [
            'width'  => 100,
            'height' => 100,
        ],
    ],
];
