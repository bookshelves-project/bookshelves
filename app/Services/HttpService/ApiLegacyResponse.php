<?php

namespace App\Services\HttpService;

use App\Enums\MediaTypeEnum;
use File;
use Http;
use Spatie\Image\Image;
use Str;

class ApiLegacyResponse
{
    public array|string $body = [];
    public array|string $data = [];

    public function __construct(
        public array|string $response
    ) {
    }

    public static function create(array|string $response)
    {
        $http = new ApiLegacyResponse($response);
        $http->data = $http->response;

        return $http;
    }

    public function setMedia(?string $url, MediaTypeEnum $type = MediaTypeEnum::media)
    {
        if ($url) {
            $prefix_url = config('app.legacy_api_url').'/storage/';

            $path = public_path("storage/{$type->name}/");
            $ext = explode('.', $url);
            $ext = end($ext);

            $response = Http::get("{$prefix_url}{$url}");
            $content = $response->body();
            $image_name = uniqid();

            $media_path = "{$path}{$image_name}";
            File::put("{$media_path}.{$ext}", $content);
            if ('webp' !== $ext) {
                Image::load("{$media_path}.{$ext}")->save("{$media_path}.webp");
                File::delete("{$media_path}.{$ext}");
            }

            return "/{$type->name}/{$image_name}.webp";
        }
    }

    public function setBlocks(?string $blocks, MediaTypeEnum $type = MediaTypeEnum::media)
    {
        if (! $blocks) {
            return null;
        }
        $blocks_parsed = json_decode($blocks, true);
        if (! $blocks_parsed) {
            return null;
        }
        foreach ($blocks_parsed as $key => $value) {
            if (array_key_exists('image', $value)) {
                $media_path = $this->setMedia($value['image'], $type);
                $blocks_parsed[$key]['image'] = $media_path;
            }
        }

        return $blocks_parsed;
    }

    public function setBody(?string $body): ?string
    {
        if ($body) {
            $regex = preg_replace_callback('"\b(/uploads.*?.png)"', function ($replaced) {
                $replaced = str_replace('/uploads/', '', $replaced[1]);
                $replaced = str_replace('.png', '.webp', $replaced);
                $file_name = explode('.', $replaced);
                $file_name = Str::slug(str_replace('%20', '_', $file_name[0]));
                $file_name = "{$file_name}.webp";

                return "/storage/media/{$file_name}";
            }, $body);
            $regex = str_replace('https://www.useweb.fr', config('app.url'), $regex);

            return str_replace('\r\n\r\n\r\n\r\n', '', $regex);
        }

        return null;
    }

    public function key(string $key)
    {
        return array_key_exists($key, $this->data)
            ? $this->data[$key]
            : false;
    }
}
