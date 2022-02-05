<?php

namespace App\Enums;

/**
 * @method static self tag()
 * @method static self genre()
 */
final class TagTypeEnum extends Enum
{
    protected static function labels(): array
    {
        return [
            'tag' => 'Tag',
            'genre' => 'Genre',
        ];
    }
}
