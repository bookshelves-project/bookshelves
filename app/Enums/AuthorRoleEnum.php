<?php

namespace App\Enums;

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
