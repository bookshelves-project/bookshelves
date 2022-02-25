<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self aut()
 */
final class AuthorRoleEnum extends Enum
{
    protected static function labels(): array
    {
        return [
            'aut' => 'Author',
        ];
    }
}
