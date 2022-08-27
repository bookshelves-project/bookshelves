<?php

namespace App\Enums;

use App\Traits\LazyEnum;

enum PublishStatusEnum: string
{
    use LazyEnum;

    case draft = 'draft';
    case scheduled = 'scheduled';
    case published = 'published';
}
