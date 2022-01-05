<?php

namespace App\Support;

use Config;
use Illuminate\Support\Facades\File;

class LaravelViteManifest
{
    private $manifestCache = [];

    public function embed(string $name, string $entry, int $port): string
    {
        if (Config::get('vite.dev_server')) {
            $host = Config::get('vite.dev_server_host');

            return $this->jsImports(
                "http://{$host}:{$port}/{$entry}"
            );
        }

        if ($assets = $this->productionAssets($name, $entry)) {
            return $this->jsImports($assets)
            .$this->jsPreloadImports($name, $entry)
            .$this->cssImports($name, $entry);
        }

        return '';
    }

    private function getManifest(string $name): array
    {
        if (! empty($this->manifestCache[$name])) {
            return $this->manifestCache[$name];
        }

        $manifest = public_path("dist/{$name}/manifest.json");

        if (File::exists($manifest)) {
            $this->manifestCache[$name] = json_decode(File::get($manifest), true);
        }

        return $this->manifestCache[$name] ?? [];
    }

    private function jsImports(string $url): string
    {
        return "<script type=\"module\" crossorigin src=\"{$url}\"></script>";
    }

    private function jsPreloadImports(string $name, string $entry): string
    {
        $res = '';
        foreach ($this->preloadUrls($name, $entry) as $url) {
            $res .= "<link rel=\"modulepreload\" href=\"{$url}\">";
        }

        return $res;
    }

    private function preloadUrls(string $name, string $entry): array
    {
        $urls = [];
        $manifest = $this->getManifest($name);

        if (! empty($manifest[$entry]['imports'])) {
            foreach ($manifest[$entry]['imports'] as $imports) {
                $urls[] = asset("/dist/{$name}/".$manifest[$imports]['file']);
            }
        }

        return $urls;
    }

    private function cssImports(string $name, string $entry): string
    {
        $tags = '';
        foreach ($this->cssUrls($name, $entry) as $url) {
            $tags .= "<link rel=\"stylesheet\" href=\"{$url}\">";
        }

        return $tags;
    }

    private function cssUrls(string $name, string $entry): array
    {
        $urls = [];
        $manifest = $this->getManifest($name);

        if (! empty($manifest[$entry]['css'])) {
            foreach ($manifest[$entry]['css'] as $file) {
                $urls[] = asset("/dist/{$name}/{$file}");
            }
        }

        return $urls;
    }

    private function productionAssets(string $name, string $entry): string
    {
        $manifest = $this->getManifest($name);

        if (! isset($manifest[$entry])) {
            return '';
        }

        return asset("/dist/{$name}/".$manifest[$entry]['file']);
    }
}
