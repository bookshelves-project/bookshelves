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
            'contributor' => 'Contributor',
            'rights' => 'Rights',
            'volume' => 'Volume',
            'serie' => 'Series',
            'disabled' => 'Disabled',
            'released_on' => 'Released on',
            'tags_count' => 'Tags',
            'type' => 'Type',
            'publisher' => 'Publisher',
            'page_count' => 'Page count',
            'maturity_rating' => 'Maturity rating',
            'googleBook' => 'Google Book',
            'wikipediaItem' => 'Wikipedia Item',
            'isbn' => 'ISBN',
            'isbn13' => 'ISBN13',
            'identifiers' => 'Identifiers',
        ],
    ],
    'series' => [
        'name' => 'Series|Series',
        'attributes' => [
        ],
    ],
    'authors' => [
        'name' => 'Author|Authors',
        'attributes' => [
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'note' => 'Note',
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
    'wikipedia-items' => [
        'name' => 'Wikipedia Item|Wikipedia Items',
        'attributes' => [
            'search_query' => 'Search query',
            'serie' => 'Series',
            'author' => 'Author',
            'page_id' => 'Page ID',
            'query_url' => 'Query URL',
        ],
    ],
    'google-books' => [
        'name' => 'Google Book|Google Books',
        'attributes' => [
            'original_isbn' => 'ISBN',
            'book' => 'book',
            'url' => 'url',
        ],
    ],
];
