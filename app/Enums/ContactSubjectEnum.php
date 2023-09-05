<?php

namespace App\Enums;

use Kiwilan\Steward\Traits\LazyEnum;

enum ContactSubjectEnum: string
{
    use LazyEnum;

    case contact = 'Contact';

    case project = 'Project';

    case quotation = 'Devis';

    case recruitement = 'Recrutement';
}
