<?php

namespace App;

class Bookshelves
{
    public function appVersion(): string
    {
        $cache = 'app-version';
        if (cache()->has($cache)) {
            return cache($cache);
        }

        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        $appVersion = $composer['version'] ?? '0.0.0';
        cache()->put($cache, $appVersion);

        return $appVersion;
    }

    // public function tmdbApiKey(): string
    // {
    //     $key = config('bookshelves.tmdb.api_key');

    //     if (! $key) {
    //         throw new \Exception('TMDB API key is not set');
    //     }

    //     return $key;
    // }

    // public function downloadLimit(): int
    // {
    //     return config('bookshelves.download_limit');
    // }

    // public function useVerbose(): bool
    // {
    //     return config('bookshelves.verbose');
    // }

    // public function useMaintenance(): bool
    // {
    //     return app(GeneralSettings::class)->maintenance;
    // }

    // public function analyzerEngine(): string
    // {
    //     return config('bookshelves.analyzer.engine');
    // }

    // public function analyzerMetadata(): string
    // {
    //     return config('bookshelves.analyzer.metadata');
    // }

    // public function analyzerLimit(): int|false
    // {
    //     $limit = config('bookshelves.analyzer.limit', false);
    //     if ($limit === null) {
    //         return false;
    //     }

    //     return $limit;
    // }

    // public function notificationDiscord(): string
    // {
    //     $discord = config('bookshelves.notification.discord');

    //     if (! $discord) {
    //         throw new \Exception('Discord notification is not set');
    //     }

    //     return $discord;
    // }

    // public function library(string $path): LibraryEnum
    // {
    //     $library = $this->findLibrary($path);

    //     if (! $library) {
    //         throw new \Exception("Library {$path} is not valid");
    //     }

    //     return $library;
    // }

    // private function findLibrary(string $path): ?LibraryEnum
    // {
    //     $library = null;
    //     $cases = LibraryEnum::cases();
    //     foreach ($cases as $enum) {
    //         if (str_contains($path, $this->path($enum))) {
    //             $library = $enum;
    //         }
    //     }

    //     return $library;
    // }

    // public function path(LibraryEnum $library): string
    // {
    //     return "{$library->value}/";
    // }

    // public function relativePath(string $path): string
    // {
    //     $relative_path = null;

    //     foreach ($this->toArray() as $value) {
    //         if (str_contains($path, "{$value}/")) {
    //             $relative_path = explode("{$value}/", $path)[1];
    //         }
    //     }

    //     if (! $relative_path) {
    //         throw new \Exception("Path {$path} is not valid");
    //     }

    //     return $relative_path;
    // }

    // public function localPath(string $path): string
    // {
    //     $local_path = null;

    //     foreach ($this->toArray() as $value) {
    //         if (str_contains($path, "{$value}/")) {
    //             $local_path = explode("{$value}/", $path)[1];
    //             $local_path = "{$value}/{$local_path}";
    //         }
    //     }

    //     if (! $local_path) {
    //         throw new \Exception("Path {$path} is not valid");
    //     }

    //     if (str_contains($local_path, LibraryEnum::dropzone->value)) {
    //         return "downloads/{$local_path}";
    //     }

    //     return "downloads/video/{$local_path}";
    // }

    // public function metadata(): string
    // {
    //     $path = storage_path('app/metadata.json');
    //     if (! file_exists($path)) {
    //         file_put_contents($path, json_encode([]));
    //     }

    //     return $path;
    // }

    // public function json(LibraryEnum $library): string
    // {
    //     $name = strtolower($library->value);
    //     $name = str_replace('_', '-', $name);
    //     $path = storage_path("app/{$name}.json");

    //     if (! file_exists($path)) {
    //         Notifier::warning("JSON file `{$name}` is not exists");
    //         file_put_contents($path, json_encode([]));
    //     }

    //     return $path;
    // }

    // /**
    //  * @return string[]
    //  */
    // public function toArray(): array
    // {
    //     $cases = LibraryEnum::cases();

    //     return array_map(fn ($enum) => $enum->value, $cases);
    // }
}
