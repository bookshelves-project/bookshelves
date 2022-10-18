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
        public string $path
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        if (! File::exists($this->path)) {
            return;
        }

        $is_svg = 'svg' === File::extension($this->path);
        $file = File::name($this->path);

        if ($is_svg) {
            if (extension_loaded('imagick')) {
                return;
            }
            $image = new Imagick();
            $image->setBackgroundColor(new ImagickPixel('transparent'));
            $image->readImageBlob(file_get_contents($this->path));
            $image->setImageFormat('png24');
            $image->resizeImage(512, 512, imagick::FILTER_LANCZOS, 1);

            $png_path = str_replace('.svg', '.png', $this->path);
            $image->writeImage($png_path);

            $this->path = $png_path;
        }

        $generate = [
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

        foreach ($generate as $icon => $config) {
            Log::info("Generating favicon: {$icon}");
            $this->resize(
                width: $config['width'],
                height: $config['height'],
                name: $config['name'],
                extension: $config['extension'],
            );

            if ($config['resize']) {
                $this->resize(
                    width: $config['resize'],
                    height: $config['resize'],
                    name: $config['name'],
                    extension: $config['extension'],
                );
            }
        }

        $settings = app(GeneralSettings::class);
        $this->setBrowserConfig($settings->site_color);
        $this->setSiteWebManifest($settings->site_name, $settings->site_color);

        // <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        // <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        // <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        // <link rel="manifest" href="/site.webmanifest">
        // <meta name="msapplication-TileColor" content="#da532c">
        // <meta name="theme-color" content="#ffffff">
    }

    private function resize(int $width, int $height, string $name, string $extension)
    {
        $image = Image::load($this->path);
        $image->manipulate(function (Manipulations $manipulations) use ($width, $height) {
            return $manipulations
                ->width($width)
                ->height($height)
                ->optimize()
            ;
        })->save(public_path("{$name}.{$extension}"));
    }

    private function setBrowserConfig(string $color)
    {
        $browser_config = `<?xml version="1.0" encoding="utf-8"?>
        <browserconfig>
            <msapplication>
                <tile>
                    <square150x150logo src="/mstile-150x150.png"/>
                    <TileColor>{$color}</TileColor>
                </tile>
            </msapplication>
        </browserconfig>`;

        File::put(public_path('browserconfig.xml'), $browser_config);
    }

    private function setSiteWebManifest(string $name, string $color)
    {
        $site_web_manifest = `{
            "name": "{$name}",
            "short_name": "{$name}",
            "icons": [
              {
                "src": "/android-chrome-192x192.png",
                "sizes": "192x192",
                "type": "image/png"
              },
              {
                "src": "/android-chrome-512x512.png",
                "sizes": "512x512",
                "type": "image/png"
              }
            ],
            "theme_color": "{$color}",
            "background_color": "{$color}",
            "display": "standalone"
        }`;

        File::put(public_path('site.webmanifest'), $site_web_manifest);
    }
}
