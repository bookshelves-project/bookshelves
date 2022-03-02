<?php

namespace App\Engines\ParserEngine\Models;

class BookCreator
{
    public function __construct(
        public ?string $name = null,
        public ?string $role = null,
    ) {
    }
}
