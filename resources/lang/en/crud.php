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
            'title' => 'Title',
            'slug' => 'Slug',
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
            'title' => 'Title',
            'slug' => 'Slug',
            'volume' => 'Volume',
            'authors' => 'Authors',
            'serie' => 'Series',
            'disabled' => 'Disabled',
            'released_on' => 'Released on',
            'cover' => 'Cover',
            'tags_count' => 'Tags',
            'language' => 'Language',
            'type' => 'Type',
        ],
    ],
    'series' => [
        'name' => 'Series|Series',
        'attributes' => [
            'title' => 'Title',
            'authors' => 'Authors',
            'books_count' => 'Books',
            'tags_count' => 'Tags',
            'language' => 'Language',
        ],
    ],
    'authors' => [
        'name' => 'Author|Authors',
        'attributes' => [
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'name' => 'Name',
            'description' => 'Description',
            'books_count' => 'Books',
            'series_count' => 'Series',
        ],
    ],
    'submissions' => [
        'name' => 'Submission|Submissions',
        'attributes' => [
            'name' => 'Name',
            'email' => 'Email',
            'message' => 'Message',
        ],
    ],
    'tags' => [
        'name' => 'Tag|Tags',
        'attributes' => [
            'name' => 'Name',
            'first_char' => 'First char',
            'type' => 'Type',
            'books_count' => 'Books',
            'series_count' => 'Series',
        ],
    ],
];
