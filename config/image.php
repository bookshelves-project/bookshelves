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

    'driver' => env('IMAGE_DRIVER', 'gd'),
    'format' => 'webp',

    'pictures' => [
        
    ],

    'covers' => [
        // Custom sizes
        // 1.6:1 aspect ratio cover
        'full' => [
            'width'  => 400,
            'height' => 640,
        ],
        // 1.6:1 aspect ratio thumbnail
        'simple' => [
            'width'  => 100,
            'height' => 160,
        ],
        'thumbnail' => [
            'width'  => 200,
            'height' => 320,
        ],
        'og' => [
            'width'  => 600,
            'height' => 300,
        ],
    ],

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
        'avatar' => [
            'width'  => 250,
            'height' => 250,
        ],
    ],
];
