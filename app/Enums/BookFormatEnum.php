<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self epub()
 * @method static self cbz()
 * @method static self pdf()
 */
final class BookFormatEnum extends Enum
{
    protected static function labels(): array
    {
        return [
            'epub' => 'epub',
            'cbz' => 'cbz',
            'pdf' => 'pdf',
        ];
    }
}
