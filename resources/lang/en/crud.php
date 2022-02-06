<?php

return [
    'users' => [
        'name' => 'User|Users',
        'attributes' => [
            'role' => 'Role',
            'last_login_at' => 'Last login at',
        ],
    ],
    'posts' => [
        'name' => 'Post|Posts',
        'attributes' => [
            'category' => 'Category',
            'status' => 'Status',
            'summary' => 'Summary',
            'body' => 'Body',
            'pin' => 'Pin',
            'promote' => 'Promote',
            'published_at' => 'Published at',
            'meta_title' => 'Meta title',
            'meta_description' => 'Meta description',
            'featured_image' => 'Image',
            'user' => 'Author',
            'tags' => 'Tags',
        ],
    ],
    'books' => [
        'name' => 'Book|Books',
        'attributes' => [
            'volume' => 'Volume',
            'authors' => 'Authors',
            'serie' => 'Series',
            'disabled' => 'Disabled',
            'released_on' => 'Released on',
            'cover' => 'Cover',
            'tags_count' => 'Tags',
            'language' => 'Language',
            'type' => 'Type',
            'publisher' => 'Publisher',
        ],
    ],
    'series' => [
        'name' => 'Series|Series',
        'attributes' => [
            'authors' => 'Authors',
            'language' => 'Language',
        ],
    ],
    'authors' => [
        'name' => 'Author|Authors',
        'attributes' => [
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'description' => 'Description',
        ],
    ],
    'submissions' => [
        'name' => 'Submission|Submissions',
        'attributes' => [
            'message' => 'Message',
        ],
    ],
    'tags' => [
        'name' => 'Tag|Tags',
        'attributes' => [
            'first_char' => 'First char',
            'type' => 'Type',
        ],
    ],
    'languages' => [
        'name' => 'Language|Languages',
        'attributes' => [
        ],
    ],
    'publishers' => [
        'name' => 'Publisher|Publishers',
        'attributes' => [
        ],
    ],
];
