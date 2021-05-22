<?php

return [
    'mails' => [
        'to'   => 'info@bookshelves.com',
        'from' => 'noreplyinfo@bookshelves.com',
    ],
    'cover_extension' => 'webp',
    'admin'           => [
        'email'    => env('BOOKSHELVES_ADMIN_EMAIL', 'admin@mail.com'),
        'password' => env('BOOKSHELVES_ADMIN_PASSWORD', 'password'),
    ],
    'genres' => [
        'Action and adventures',
        'Crime and mystery',
        'Fantasy',
        'Horror',
        'Romance',
        'Science fiction',
    ],
];
