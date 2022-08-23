<?php

namespace App\Enums;

use App\Traits\LazyEnum;

enum ColorEnum: string
{
    use LazyEnum;

    case yellow = 'Jaune';
    case purple = 'Mauve';
    case red = 'Rouge';
    case cyan = 'Cyan';
}
