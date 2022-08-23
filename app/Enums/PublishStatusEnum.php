<?php

namespace App\Enums;

use App\Traits\LazyEnum;

enum PublishStatusEnum: string
{
    use LazyEnum;

    case draft = 'Brouillon';
    case scheduled = 'Planifié';
    case published = 'Publié';
}
