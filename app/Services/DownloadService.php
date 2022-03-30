<?php

namespace App\Services;

class DownloadService
{
    public static function getFile(string $name, ?string $size, ?string $url = null, ?string $format = null, ?int $count = 0, bool $is_zip = false): array
    {
        return [
            'name' => $name,
            'size' => $size,
            'url' => $url,
            'format' => $format,
            'count' => $count,
            'isZip' => $is_zip,
        ];
    }
}
