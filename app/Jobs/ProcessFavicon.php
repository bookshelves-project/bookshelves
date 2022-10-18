<?php

namespace App\Jobs;

use App\Settings\GeneralSettings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Imagick;
use ImagickPixel;
use Log;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class ProcessFavicon implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $settings = app(GeneralSettings::class);
        $this->setIcon($settings->site_favicon);

        // <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        // <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        // <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        // <link rel="manifest" href="/site.webmanifest">
        // <meta name="msapplication-TileColor" content="#da532c">
        // <meta name="theme-color" content="#ffffff">
    }

    public function dedent(string $str)
    {
        $parts = array_filter(explode("\n", $str), function ($part) {
            return trim($part);
        });
        $spaces = min(array_map(function ($part) {
            preg_match('#^ *#', $part, $matches);
            return strlen($matches[0]);
        }, $parts));
        $parts = array_map(function ($part) use ($spaces) {
            return substr($part, $spaces);
        }, $parts);
        return implode("\n", $parts);
    }

    public function indent(string $str, int $spaces = 4)
    {
        $parts = array_filter(explode("\n", $str));
        $parts = array_map(function ($part) use ($spaces) {
            return str_repeat(' ', $spaces).$part;
        }, $parts);
        return implode("\n", $parts);
    }

    private function setIcon(string $path)
    {
        $path = public_path("storage/{$path}");

        if (! $path || ! File::exists($path)) {
            return;
        }

        $is_svg = 'svg' === File::extension($path);

        if ($is_svg) {
            if (extension_loaded('imagick')) {
                return;
            }
            $image = new Imagick();
            $image->setBackgroundColor(new ImagickPixel('transparent'));
            $image->readImageBlob(file_get_contents($path));
            $image->setImageFormat('png24');
            $image->resizeImage(512, 512, imagick::FILTER_LANCZOS, 1);

            $png_path = str_replace('.svg', '.png', $path);
            $image->writeImage($png_path);

            $path = $png_path;
        }

        $icons = [
            'android-chrome-192' => [
                'name' => 'android-chrome-192x192',
                'extension' => 'png',
                'width' => 192,
                'height' => 192,
                'resize' => null,
            ],
            'android-chrome-512' => [
                'name' => 'android-chrome-512x512',
                'extension' => 'png',
                'width' => 512,
                'height' => 512,
                'resize' => null,
            ],
            'apple-touch-icon' => [
                'name' => 'apple-touch-icon',
                'extension' => 'png',
                'width' => 180,
                'height' => 180,
                'resize' => null,
            ], // 180x180
            'favicon-16' => [
                'name' => 'favicon-16x16',
                'extension' => 'png',
                'width' => 16,
                'height' => 16,
                'resize' => null,
            ],
            'favicon-32' => [
                'name' => 'favicon-32x32',
                'extension' => 'png',
                'width' => 32,
                'height' => 32,
                'resize' => null,
            ],
            'favicon' => [
                'name' => 'favicon',
                'extension' => 'ico',
                'width' => 48,
                'height' => 48,
                'resize' => null,
            ], // 48x48
            'mstile-150' => [
                'name' => 'mstile-150x150',
                'extension' => 'png',
                'width' => 150,
                'height' => 150,
                'resize' => 270,
            ],
        ];

        foreach ($icons as $icon => $config) {
            Log::info("Generating favicon: {$icon}");
            $this->iconResize(
                path: $path,
                width: $config['width'],
                height: $config['height'],
                name: $config['name'],
                extension: $config['extension'],
            );

            if ($config['resize']) {
                $this->iconResize(
                    path: $path,
                    width: $config['resize'],
                    height: $config['resize'],
                    name: $config['name'],
                    extension: $config['extension'],
                );
            }
        }
    }

    private function iconResize(string $path, int $width, int $height, string $name, string $extension)
    {
        $image = Image::load($path);
        $image->manipulate(function (Manipulations $manipulations) use ($width, $height) {
            return $manipulations
                ->width($width)
                ->height($height)
                ->optimize()
            ;
        })->save(public_path("{$name}.{$extension}"));
    }
}
