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
    'authors' => [
        // For all ebooks: if you have authors' names like lastname_firstname
        // set to false to reverse
        'firstname_lastname' => true,
    ],
    // From Wikipedia: https://en.wikipedia.org/wiki/List_of_writing_genres.
    // Any tag add here will be used as 'genre'
    'genres' => [
        'Action & adventures',
        'Crime & mystery',
        'Fantasy',
        'Horror',
        'Romance',
        'Science fiction',
    ],

    'forbidden_tags' => [
        'SF',
        'General',
    ],

    'converted_tags' => [
        'Action & Adventure' => 'Action & adventures',
    ],
];
