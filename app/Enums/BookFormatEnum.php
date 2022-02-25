<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;

// /**
//  *
//  *
//  * @method static self epub()
//  * @method static self cbz()
//  * @method static self pdf()
//  */
// final class BookFormatEnum extends Enum
// {
//     protected static function labels(): array
//     {
//         return [
//             'epub' => 'epub',
//             'cbz' => 'cbz',
//             'pdf' => 'pdf',
//         ];
//     }
// }

/**
 * Check `ParserEngine::class`, `ConverterEngine::class` if you want to add new format.
 */
enum BookFormatEnum: string
{
    use EnumMethods;

    case epub = 'epub';
    case cbz = 'cbz';
    case pdf = 'pdf';

    public function color(): string
    {
        return match ($this) {
            BookFormatEnum::epub => 'grey',
            BookFormatEnum::cbz => 'green',
            BookFormatEnum::pdf => 'red',
        };
    }

}
