<?php

namespace App\Services;

use App\Enums\BookTypeEnum;
use App\Enums\GenderEnum;
use App\Enums\TagTypeEnum;

class EnumService
{
    public static function list(): array
    {
        $genders = GenderEnum::toArray();
        $tagTypes = TagTypeEnum::toArray();
        $bookTypes = BookTypeEnum::toArray();
        $models = [
            'author' => 'Author',
            'book' => 'Book',
            'language' => 'Language',
            'publisher' => 'Publisher',
            'serie' => 'Serie',
            'tagextended' => 'TagExtended',
        ];

        return [
            'genders' => $genders,
            'tagTypes' => $tagTypes,
            'bookTypes' => $bookTypes,
            'models' => $models,
        ];
    }
}
