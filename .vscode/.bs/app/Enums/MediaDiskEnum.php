<?php

namespace App\Enums;

use Kiwilan\Steward\Traits\LazyEnum;

enum MediaDiskEnum: string
{
    use LazyEnum;

    case cms = 'cms';
    case cover = 'cover';
    case format = 'format';
    case media = 'media';
    case post = 'post';
    case user = 'user';
}
