<?php

namespace App\Enums;

interface Enum
{
    public function labels(): array;
}
// class Enum
// {
//     protected static function labels(): array
//     {
//         return collect(__('enum::validation.enums.'.static::class))->toArray();
//     }
// }
