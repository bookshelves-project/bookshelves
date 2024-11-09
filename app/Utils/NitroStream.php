<?php

namespace App\Utils;

use App\Facades\Bookshelves;

class NitroStream
{
    public static function writeUrl(string $endpoint, string $id, ?string $type = null): string
    {
        $assetsUrl = Bookshelves::downloadNitroUrl();

        $url = "{$assetsUrl}/{$endpoint}/{$id}";
        $params = http_build_query([
            'key' => Bookshelves::downloadNitroToken(),
            'session' => session()->getId(),
            'name' => 'bookshelves',
            'bs-type' => $type,
        ]);

        return "{$url}?{$params}";
    }

    public static function clearSpaces(string $value): string
    {
        // keep only alphanumeric and spaces characters
        $value = preg_replace('/[^a-zA-Z0-9.\s]/', '', $value);

        // replace multiple spaces with a single space
        $value = preg_replace('/\s+/', ' ', $value);

        // replace spaces with dots
        $value = str_replace(' ', '.', $value);

        return $value;
    }
}
