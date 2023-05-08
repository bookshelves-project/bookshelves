<?php

namespace App\Engines\Opds\Models;

use DateTime;

class OpdsApp
{
    public function __construct(
        public string $name = 'opds',
        public ?string $author = null,
        public ?string $authorUrl = null,
        public ?string $startUrl = null,
        public ?string $searchUrl = null,
        public ?DateTime $updated = null,
    ) {
    }
}
