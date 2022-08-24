<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ConverterService
{
    public static function saveAsJson(mixed $data, string $name): void
    {
        $data = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        Storage::disk('public')->put("debug/{$name}.json", $data);
        ConsoleService::print("Saved to public/storage/debug/{$name}.json");
    }

    public static function jsonToArray(string $path, bool $is_associative = true): array
    {
        $file = File::get($path);

        return json_decode($file, $is_associative);
    }

    public static function arrayToObject(array $data): object
    {
        return json_decode(json_encode($data, JSON_FORCE_OBJECT));
    }

    public static function objectToArray(object $data): array
    {
        return json_decode(json_encode($data), true);
    }
}
