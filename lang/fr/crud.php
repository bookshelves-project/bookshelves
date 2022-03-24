<?php

return [
    'users' => [
        'name' => 'Utilisateur|Utilisateurs',
        'attributes' => [
            'role' => 'Rôle',
            'last_login_at' => 'Dernièrement connecté le',
        ],
    ],
    'posts' => [
        'name' => 'Article|Articles',
        'attributes' => [
            'title' => 'Titre',
            'slug' => 'Permalien',
            'category' => 'Catégorie',
            'status' => 'Statut',
            'summary' => 'Résumé',
            'body' => 'Corps',
            'pin' => 'Epinglé',
            'promote' => 'Mis en avant',
            'published_at' => 'Publié le',
            'meta_title' => 'Meta title',
            'meta_description' => 'Meta description',
            'featured_image' => 'Image',
            'user' => 'Auteur',
            'tags' => 'Tags',
        ],
    ],
    'books' => [
        'name' => 'Livre|Books',
        'attributes' => [
            'volume' => 'Volume',
            'serie' => 'Série',
            'disabled' => 'Désactivé',
            'released_on' => 'Publié le',
            'cover' => 'Couverture',
            'type' => 'Type',
            'publisher' => 'Éditeur',
        ],
    ],
    'series' => [
        'name' => 'Série|Séries',
        'attributes' => [
            'authors' => 'Auteurs',
            'language' => 'Langage',
        ],
    ],
    'authors' => [
        'name' => 'Auteur|Auteurs',
        'attributes' => [
            'firstname' => 'Prénom',
            'lastname' => 'Nom',
            'description' => 'Description',
        ],
    ],
    'submissions' => [
        'name' => 'Soumission|Soumissions',
        'attributes' => [
            'message' => 'Message',
        ],
    ],
    'tags' => [
        'name' => 'Tag|Tags',
        'attributes' => [
            'first_char' => 'Première lettre',
            'type' => 'Type',
        ],
    ],
    'languages' => [
        'name' => 'Langage|Langages',
        'attributes' => [
        ],
    ],
    'publishers' => [
        'name' => 'Éditeur|Éditeurs',
        'attributes' => [
        ],
    ],
    'wikipedia-items' => [
        'name' => 'Wikipedia Item|Wikipedia Items',
        'attributes' => [
        ],
    ],
    'google-books' => [
        'name' => 'Google Book|Google Books',
        'attributes' => [
        ],
    ],
    'pages' => [
        'name' => 'Page|Pages',
        'attributes' => [
        ],
    ],
];
