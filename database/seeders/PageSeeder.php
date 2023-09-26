<?php

namespace Database\Seeders;

use App\Enums\MediaDiskEnum;
use App\Models\Page;
use File;
use Illuminate\Database\Seeder;
use Kiwilan\Steward\Services\ConverterService;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Page::query()
            ->delete();

        $templates_path = database_path('seeders/data/cms/pages');
        $media_disk = MediaDiskEnum::cms;
        $media_path = database_path('seeders/media');

        $templates = File::allFiles($templates_path);

        foreach ($templates as $file) {
            $data = ConverterService::jsonToArray($file->getPathname());
            $template = Page::create($data);

            $array = $template->toArray();

            $needles = ['media'];
            $result = [];
            array_walk_recursive(
                $array,
                function ($value, $key) use ($needles, &$result, $media_path, $media_disk) {
                    if (
                        in_array($key, $needles)
                        && ! isset($result[$key])
                    ) {
                        $path = "{$media_path}/{$value}";
                        $media = File::get($path);
                        $pathinfo = pathinfo($value);
                        $file = "{$pathinfo['filename']}.{$pathinfo['extension']}";

                        File::put(public_path("storage/{$media_disk->value}/{$file}"), $media);
                    }
                }
            );
        }
    }
}
