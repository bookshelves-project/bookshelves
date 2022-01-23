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
];
