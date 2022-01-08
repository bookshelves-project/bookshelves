<?php

namespace App\Services;

use App\Enums\GenderEnum;

class EnumService
{
    public static function list(): array
    {
        $genders = GenderEnum::toArray();
        $models = [
            'author' => 'Author',
            'book' => 'Book',
            'comicbook' => 'ComicBook',
            'language' => 'Language',
            'publisher' => 'Publisher',
            'serie' => 'Serie',
            'tagextended' => 'TagExtended',
        ];

        return [
            'genders' => $genders,
            'models' => $models,
        ];
    }
}
