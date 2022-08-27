<?php

namespace Database\Seeders;

use App\Enums\MediaDiskEnum;
use App\Models\Cms\Page;
use App\Services\ConverterService;
use File;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Page::query()
            ->delete()
        ;

        $templates_path = database_path('seeders/data/cms/templates');
        $media_disk = MediaDiskEnum::cms;
        $media_path = database_path('seeders/media');

        $templates = File::allFiles($templates_path);

        foreach ($templates as $file) {
            $data = ConverterService::jsonToArray($file->getLinkTarget());
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
