<?php

namespace App\Utils;

use App\Facades\Bookshelves;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NitroStream
{
    public static function writeUrl(string|int $id, string $table = 'books', bool $zip = false, ?string $type = null): string
    {
        $assetsUrl = Bookshelves::downloadNitroUrl();

        $url = "{$assetsUrl}/download";
        $params = http_build_query([
            'csrf_token' => csrf_token(),
            'session' => session()->getId(),
            'nitro_key' => Bookshelves::downloadNitroKey(),
            'remember_token' => Auth::user()?->getRememberToken(),
            'database' => DB::connection()->getDatabaseName(),
            'table' => $table,
            'id' => $id,
            'zip' => $zip,
            'type' => 'bookshelves',
            'bs_type' => $type,
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
