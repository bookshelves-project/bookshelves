<?php

namespace App\Enums;

use App\Traits\LazyEnum;

enum TemplateEnum: string
{
    use LazyEnum;

    case basic = 'basic';
    case home = 'home';
    case about = 'about';
}
