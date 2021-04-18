<?php

namespace App\Providers\MetadataExtractor\Parsers;

class Creator
{
    public function __construct(
        public ?string $name = null,
        public ?string $role = null,
    ) {
    }
}
