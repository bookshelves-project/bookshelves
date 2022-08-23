<?php

namespace App\Enums;

use App\Traits\LazyEnum;

enum ContactSubjectEnum: string
{
    use LazyEnum;

    case contact = 'Contact';
    case project = 'Project';
    case quotation = 'Devis';
    case recruitement = 'Recrutement';
}
