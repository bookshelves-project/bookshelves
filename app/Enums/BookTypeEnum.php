<?php

namespace App\Enums;

use App\Bookshelves;
use Kiwilan\Steward\Traits\LazyEnum;

enum BookTypeEnum: string
{
    use LazyEnum;

    case audiobook = 'audiobook';

    case book = 'book';

    case comic = 'comic';

    case manga = 'manga';

    public function path(): ?string
    {
        $name = "{$this->value}s";

        return app(Bookshelves::class)->library()[$name];
    }
}
