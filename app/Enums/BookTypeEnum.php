<?php

namespace App\Enums;

/**
 * @method static self comic()
 * @method static self essay()
 * @method static self handbook()
 * @method static self novel()
 */
final class BookTypeEnum extends Enum
{
    protected static function labels(): array
    {
        return [
            'handbook' => 'Handbook',
            'essay' => 'Essay',
            'comic' => 'Comic',
            'novel' => 'Novel',
        ];
    }
}
