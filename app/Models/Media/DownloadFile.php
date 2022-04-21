<?php

namespace App\Models\Media;

class DownloadFile
{
    public function __construct(
        public ?string $name = null,
        public ?string $size = null,
        public ?string $url = null,
        public ?string $reader = null,
        public ?string $format = null,
        public ?int $count = null,
        public ?bool $isZip = null,
    ) {
    }
}
