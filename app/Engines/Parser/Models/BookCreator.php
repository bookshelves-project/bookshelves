<?php

namespace App\Engines\Parser\Models;

class BookCreator
{
    public function __construct(
        public ?string $name = null,
        public ?string $role = null,
    ) {
    }
}
