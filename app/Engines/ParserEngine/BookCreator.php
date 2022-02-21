<?php

namespace App\Engines\ParserEngine;

class BookCreator
{
    public function __construct(
        public ?string $name = null,
        public ?string $role = null,
    ) {
    }
}
