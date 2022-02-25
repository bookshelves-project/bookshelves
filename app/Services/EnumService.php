<?php

namespace App\Services;

use App\Enums\GenderEnum;
use App\Enums\TagTypeEnum;
use App\Enums\BookTypeEnum;
use App\Enums\BookFormatEnum;

class EnumService
{
    public static function list(): array
    {
        $genders = GenderEnum::toArray();
        $tagTypes = TagTypeEnum::toArray();
        $bookTypes = BookTypeEnum::toArray();
        $bookFormats = BookFormatEnum::toArray();
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
            'bookFormats' => $bookFormats,
            'models' => $models,
        ];
    }
}
