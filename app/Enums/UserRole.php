<?php

namespace App\Enums;

use App\Traits\LazyEnum;

enum UserRole: string
{
    use LazyEnum;

    case super_admin = 'Super admin';
    case admin = 'Admin';
    case editor = 'Editeur';
    case user = 'Utilisateur';
}
