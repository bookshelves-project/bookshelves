<?php

namespace App\Providers\MetadataExtractor\Parsers;

class CreatorParser
{
    public function __construct(
        public ?string $name = null,
        public ?string $role = null,
    ) {
    }
}
