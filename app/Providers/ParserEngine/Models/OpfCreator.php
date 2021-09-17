<?php

namespace App\Providers\ParserEngine\Models;

class OpfCreator
{
    public function __construct(
        public ?string $name = null,
        public ?string $role = null,
    ) {
    }
}
