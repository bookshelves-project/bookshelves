<?php

use App\Enums\RoleEnum;
use App\Enums\PostStatusEnum;

return [
    'enum' => 'The :attribute field is not a valid :enum.',
    'enum_index' => 'The :attribute field is not a valid index of :enum.',
    'enum_name' => 'The :attribute field is not a valid name of :enum.',
    'enum_value' => 'The :attribute field is not a valid value of :enum.',

    'enums' => [
        // RoleEnum::class => [
        //     'super_admin' => 'Super admin',
        //     'admin' => 'Admin',
        //     'user' => 'User',
        // ],
        // PostStatusEnum::class => [
        //     'draft' => 'Draft',
        //     'scheduled' => 'Scheduled',
        //     'published' => 'Published',
        // ],
        'book_format' => [
            'epub' => 'EPUB',
            'cbz' => 'CBZ',
            'pdf' => 'PDF',
        ],
    ],
];
