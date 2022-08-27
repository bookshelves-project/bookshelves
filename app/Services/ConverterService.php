<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ConverterService
{
    public const CONFIG = [
        'APP_NAME' => 'app.name',
        'APP_URL' => 'app.url',
        'APP_FRONT_URL' => 'app.front_url',
    ];

    public static function saveAsJson(mixed $data, string $name): void
    {
        $data = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        Storage::disk('public')->put("debug/{$name}.json", $data);
        ConsoleService::print("Saved to public/storage/debug/{$name}.json");
    }

    public static function jsonToArray(string $path, bool $is_associative = true, bool $replace_dotenv = true): array
    {
        $file = File::get($path);
        if ($replace_dotenv) {
            $file = ConverterService::replaceWithDotenv($file);
        }

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

    public static function replaceWithDotenv(string $string): string
    {
        foreach (self::CONFIG as $dotenv_key => $config_key) {
            $string = str_replace($dotenv_key, config($config_key), $string);
        }

        return $string;
    }
}
