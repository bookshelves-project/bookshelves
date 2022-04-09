<?php

namespace App\Services;

use App\Enums\MediaDiskEnum;
use App\Models\MediaExtended;
use App\Models\Page;
use App\Models\Post;
use DOMDocument;
use DOMNodeList;
use DOMXPath;
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
                'ROUTE_WEBREADER' => route('front.webreader'),
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
        $service->html = self::improveHtml($service->html);

        return $service->html ? $service : false;
    }

    public static function improveHtml(string $html): string
    {
        $html = preg_replace('/<a(.*?)>/', '<a$1 target="_blank" rel="noopener noreferrer">', $html);
        return preg_replace('/<img(.*?)>/', '<img$1 loading="lazy">', $html);
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
            MediaService::create($model, $model->{$model_name_attr}, MediaDiskEnum::cms, $featured_image_name)
                ->setMedia($image)
                ->setColor()
            ;
        }

        foreach ($this->image_paths as $name) {
            $path_src = database_path("seeders/media/{$this->type}/{$name}");
            if (File::exists($path_src)) {
                $src = base64_encode(File::get($path_src));
                MediaService::create($model, $name, MediaDiskEnum::cms, $inside_images_name)
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

        $this->html = self::saveHtml($this->html, $this->document);
        // $this->html = $this->minifyOutput($this->html);

        $model->{$model_body_attr} = $this->html;
        $model->save();
    }

    public static function setHeadings(
        Post|Page $model,
        string $model_body_attr = 'body'
    ) {
        try {
            $document = new DOMDocument();
            $document->loadHTML($model->{$model_body_attr});
            $xpath = new DOMXPath($document);

            $elements = $xpath->query('(//h1|//h2|//h3|//h4|//h5)');

            foreach ($elements as $index => $element) {
                $element->setAttribute('id', Str::slug($element->textContent));
            }
            $html = self::saveHtml($model->{$model_body_attr}, $document);

            return self::improveHtml($html);
        } catch (\Throwable $th) {
            // throw $th;
        }
    }

    public static function saveHtml(?string $html, ?DOMDocument $document): ?string
    {
        $html = $document->saveHTML($document->documentElement);
        if ($document->doctype) {
            $document->removeChild($document->doctype);
        }
        $html = utf8_decode($document->saveHTML($document->documentElement));
        $html = str_replace('<html><body>', '', $html);
        $html = str_replace('</body></html>', '', $html);
        $html = str_replace('<p><img', '<img', $html);
        return str_replace('"></p>', '">', $html);
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
