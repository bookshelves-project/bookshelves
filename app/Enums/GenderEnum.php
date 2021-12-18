<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self unknown()
 * @method static self woman()
 * @method static self nonbinary()
 * @method static self genderfluid()
 * @method static self agender()
 * @method static self man()
 */
final class GenderEnum extends Enum
{
    protected static function labels(): array
    {
        return [
            'unknown' => 'Unkown',
            'woman' => 'Woman',
            'nonbinary' => 'Non binary',
            'genderfluid' => 'Genderfluid',
            'agender' => 'Agender',
            'man' => 'Man',
        ];
    }
}
