<?php

namespace App\Services;

use App\Enums\GenderEnum;

class EnumService
{
    public static function list(): array
    {
        $genders = GenderEnum::toArray();

        return [
            'genders' => $genders,
        ];
    }
}
