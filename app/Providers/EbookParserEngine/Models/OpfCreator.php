<?php

namespace App\Providers\EbookParserEngine\Models;

class OpfCreator
{
    public function __construct(
        public ?string $name = null,
        public ?string $role = null,
    ) {
    }
}
