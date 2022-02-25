<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self draft()
 * @method static self scheduled()
 * @method static self published()
 */
final class PostStatusEnum extends Enum
{
}
