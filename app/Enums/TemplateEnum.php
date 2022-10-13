<?php

namespace App\Enums;

use Kiwilan\Steward\Traits\LazyEnum;

enum TemplateEnum: string
{
    use LazyEnum;

    case home = 'home';
    case about = 'about';
}
