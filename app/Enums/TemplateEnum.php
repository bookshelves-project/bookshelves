<?php

namespace App\Enums;

use Kiwilan\Steward\Traits\LazyEnum;

enum TemplateEnum: string
{
    use LazyEnum;

    case basic = 'basic';
    case home = 'home';
}
