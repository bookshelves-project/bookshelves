<?php

return [
    'mails' => [
        'to'   => 'info@bookshelves.com',
        'from' => 'noreplyinfo@bookshelves.com',
    ],
    'cover_extension' => 'webp',
    'admin'           => [
        'email'    => env('BOOKSHELVES_ADMIN_EMAIL', 'ewilan@dotslashplay.it'),
        'password' => env('BOOKSHELVES_ADMIN_PASSWORD', 'password'),
    ],
];
