<?php

return [
    'enum' => 'The :attribute field is not a valid :enum.',
    'enum_index' => 'The :attribute field is not a valid index of :enum.',
    'enum_name' => 'The :attribute field is not a valid name of :enum.',
    'enum_value' => 'The :attribute field is not a valid value of :enum.',

    'enums' => [
        'AuthorRoleEnum' => [
            'aut' => 'Author',
        ],
        'BookFormatEnum' => [
            'epub' => 'EPUB',
            'cbz' => 'CBZ',
            'pdf' => 'PDF',
        ],
        'BookTypeEnum' => [
            'handbook' => 'Manuel',
            'essay' => 'Essai',
            'comic' => 'Bande dessinée',
            'novel' => 'Roman',
            'audio' => 'Audio',
        ],
        'GenderEnum' => [
            'unknown' => 'Unknown',
            'woman' => 'Woman',
            'nonbinary' => 'Non binary',
            'genderfluid' => 'Genderfluid',
            'agender' => 'Agender',
            'man' => 'Man',
        ],
        'PostStatusEnum' => [
            'draft' => 'Draft',
            'scheduled' => 'Scheduled',
            'published' => 'Published',
        ],
        'RoleEnum' => [
            'super_admin' => 'Super admin',
            'admin' => 'Admin',
            'user' => 'User',
        ],
        'TagTypeEnum' => [
            'tag' => 'Tag',
            'genre' => 'Genre',
        ],
    ],
];
