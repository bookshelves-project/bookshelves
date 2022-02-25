<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;

enum PostStatusEnum: string
{
    use EnumMethods;

    case draft = 'draft';

    case scheduled = 'scheduled';

    case published = 'published';
}
