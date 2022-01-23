<?php

namespace App\Services\ParserEngine\Models;

class OpfCreator
{
    public function __construct(
        public ?string $name = null,
        public ?string $role = null,
    ) {
    }
}
