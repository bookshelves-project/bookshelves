<?php

namespace App\Engines\Opds\Models;

use DateTime;

class OpdsEntry
{
    public function __construct(
        public string $id,
        public string $title,
        public string $route,
        public ?string $summary = null,
        public ?string $media = null,
        public ?DateTime $updated = null,
    ) {
        if ($summary) {
            $this->summary = strip_tags($summary);
            $this->summary = strlen($this->summary) > 200 ? substr($this->summary, 0, 200).'...' : $this->summary;
        }
    }
}
