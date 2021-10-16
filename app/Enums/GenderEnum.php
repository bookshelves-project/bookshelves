<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self UNKNOWN()
 * @method static self WOMAN()
 * @method static self NONBINARY()
 * @method static self GENDERFLUID()
 * @method static self AGENDER()
 * @method static self MAN()
 */
final class GenderEnum extends Enum
{
    protected static function labels(): array
    {
        return [
            'UNKNOWN' => 'Unkown',
            'WOMAN' => 'Woman',
            'NONBINARY' => 'Non binary',
            'GENDERFLUID' => 'Genderfluid',
            'AGENDER' => 'Agender',
            'MAN' => 'Man',
        ];
    }
}
