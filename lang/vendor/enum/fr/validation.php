<?php

use App\Enums\PostStatusEnum;
use App\Enums\RoleEnum;

return [
    'enum' => 'Le champ :attribute n\'est pas un :enum valide.',
    'enum_index' => 'Le champ :attribute n\'est pas un index valide de :enum.',
    'enum_name' => 'Le champ :attribute n\'est pas un nom valide de :enum.',
    'enum_value' => 'Le champ :attribute n\'est pas une valeur valide de :enum.',

    'enums' => [
        RoleEnum::class => [
            'super_admin' => 'Super administrateur',
            'admin' => 'Administrateur',
            'user' => 'Utilisateur',
        ],
        PostStatusEnum::class => [
            'draft' => 'Brouillon',
            'scheduled' => 'Planifié',
            'published' => 'Publié',
        ],
    ],
];
