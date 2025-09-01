<?php

namespace App\Utils;

use App\Facades\Bookshelves;
use Illuminate\Support\Facades\DB;

class NitroStream
{
    /**
     * Generate a URL to download a file from Nitro.
     *
     * @param  string|int  $id  The ID of the file to download.
     * @param  string  $table  The database table where the file is stored, it can be `books` or `series`.
     */
    public static function writeUrl(string|int $id, string $table = 'books'): string
    {
        $assetsUrl = Bookshelves::downloadNitroUrl();

        $url = "{$assetsUrl}/download";
        $params = http_build_query([
            'csrf_token' => csrf_token(),
            'session' => session()->getId(),
            'nitro_key' => Bookshelves::downloadNitroKey(),
            'database' => DB::connection()->getDatabaseName(),
            'table' => $table,
            'id' => $id,
            'project' => 'bookshelves',
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
