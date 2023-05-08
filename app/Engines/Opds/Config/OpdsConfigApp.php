<?php

namespace App\Engines\Opds\Config;

use DateTime;

class OpdsConfigApp
{
    public function __construct(
        public string $name,
        public ?string $author = null,
        public ?string $authorUrl = null,
        public ?string $startUrl = null,
        public ?string $searchUrl = null,
        public ?DateTime $updated = null,
    ) {
    }
}
