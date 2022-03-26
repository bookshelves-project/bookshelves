<?php

namespace App\Services;

use App\Models\MediaExtended;
use DOMDocument;
use DOMNodeList;
use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MarkdownToHtmlService
{
    public function __construct(
        public ?string $type = null,
        public ?DOMDocument $document = null,
        public ?DOMNodeList $image_tags = null,
        public ?array $image_paths = [],
        public ?string $path_file = null,
        public ?string $path_image = null,
        public ?string $html = null,
    ) {
    }

    public static function create(object $md, string $type): MarkdownToHtmlService|false
    {
        $service = new MarkdownToHtmlService();

        $service->type = $type;
        $service->path_file = database_path("seeders/data/{$service->type}/{$md->name}.md");
        $service->path_image = database_path("seeders/media/{$service->type}/{$md->image}.webp");

        if (File::exists($service->path_file)) {
            $content = File::get($service->path_file);

            $config = [
                'APP_NAME' => config('app.name'),
                'APP_URL' => config('app.url'),
                'APP_DOCUMENTATION_URL' => config('app.documentation_url'),
                'APP_REPOSITORY_URL' => config('app.repository_url'),
                'ROUTE_DOCS' => config('app.url').'/docs',
                'ROUTE_CATALOG' => route('front.catalog'),
                'ROUTE_OPDS_12' => route('front.opds.feed', ['version' => 'v1.2']),
            ];
            foreach ($config as $key => $value) {
                $content = str_replace($key, $value, $content);
            }
            $service->html = Str::markdown($content);

            $service->document = new DOMDocument();
            $service->document->loadHTML($service->html);

            $service->image_tags = $service->document->getElementsByTagName('img');

            $image_paths = [];
            foreach ($service->image_tags as $tag) {
                $src = $tag->getAttribute('src');
                $path = str_replace('IMAGE/', '', $src);
                array_push($image_paths, $path);
            }
            $service->image_paths = $image_paths;
        }

        return $service->html ? $service : false;
    }

    public function setImages(
        Model $model,
        string $featured_image_name,
        string $inside_images_name,
        string $model_name_attr = 'slug',
        string $model_body_attr = 'body'
    ) {
        $image = null;
        if (File::exists($this->path_image)) {
            $image = base64_encode(File::get($this->path_image));
            MediaService::create($model, $model->{$model_name_attr}, 'media', $featured_image_name)
                ->setMedia($image)
                ->setColor()
            ;
        }

        foreach ($this->image_paths as $name) {
            $path_src = database_path("seeders/media/{$this->type}/{$name}");
            if (File::exists($path_src)) {
                $src = base64_encode(File::get($path_src));
                MediaService::create($model, $name, 'media', $inside_images_name)
                    ->setMedia($src)
                    ->setColor()
                ;
            }
        }
        // @phpstan-ignore-next-line
        $medias = $model->getMedia($inside_images_name);

        foreach ($this->image_tags as $tag) {
            $src = $tag->getAttribute('src');
            $path = str_replace('IMAGE/', '', $src);
            /** @var MediaExtended $media */
            foreach ($medias as $media) {
                if ($path === $media->name) {
                    $tag->setAttribute('src', $media->getFullUrl());
                }
            }
        }
        $this->html = $this->document->saveHTML($this->document->documentElement);
        $this->document->removeChild($this->document->doctype);
        $this->html = utf8_decode($this->document->saveHTML($this->document->documentElement));
        $this->html = str_replace('<html><body>', '', $this->html);
        $this->html = str_replace('</body></html>', '', $this->html);
        $this->html = str_replace('<p><img', '<img', $this->html);
        $this->html = str_replace('></p>', '/>', $this->html);
        $this->html = $this->minifyOutput($this->html);

        $model->{$model_body_attr} = $this->html;
        $model->save();
    }

    public static function minifyOutput(string $html): string
    {
        return preg_replace(
            ['/ {2,}/', '/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'],
            [' ', ''],
            $html
        );
    }
}
