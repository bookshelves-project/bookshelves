<?php

namespace App\Engines\ConverterEngine;

use App\Enums\MediaDiskEnum;
use App\Models\Author;
use App\Models\Serie;
use App\Services\ConverterService;
use App\Services\MediaService;
use App\Services\WikipediaService\WikipediaQuery;
use File;
use Illuminate\Support\Str;
use ReflectionClass;

class EntityConverter
{
    public const DISK = MediaDiskEnum::cover;

    public static function setLocalData(Serie|Author $model): Serie|Author
    {
        $class_name = new ReflectionClass($model);
        $class_name = strtolower($class_name->getShortName());
        $path = public_path("storage/data/{$class_name}s/{$class_name}s.json");
        if (File::exists($path)) {
            $json = json_decode(File::get($path));
            $data = ConverterService::objectToArray($json);

            $local = null;
            if (array_key_exists($model->slug, $data)) {
                $local = $data[$model->slug];
            }
            if (array_key_exists($model->slug_sort, $data)) {
                $local = $data[$model->slug_sort];
            }
            if (null !== $local) {
                if (array_key_exists('description', $local)) {
                    $model->description = $local['description'];
                }
                if (array_key_exists('link', $local)) {
                    $model->link = $local['link'];
                }
                if (array_key_exists('note', $local)) {
                    $model->note = $local['note'];
                }
                $model->save();
            }
        }

        return $model;
    }

    public static function setWikipediaDescription(Serie|Author $model): Serie|Author
    {
        if ($model->wikipedia && ! $model->description && ! $model->link) {
            if ('' === $model->getTranslation('description', $model->language_slug)) {
                $model->setTranslation(
                    'description',
                    $model->language_slug,
                    Str::limit($model->wikipedia->extract, 1000)
                );
            }
            $model->link = $model->wikipedia->page_url;
            $model->save();
        }
        EntityConverter::setLocalData($model);

        return $model;
    }

    public static function setWikipediaCover(Serie|Author $model): Serie|Author
    {
        $disk = MediaDiskEnum::cover;
        if ($model->getMedia($disk->value)->isEmpty()) {
            $cover = null;
            if ($model->wikipedia) {
                $cover = WikipediaQuery::getPictureFile($model->wikipedia->picture_url);
            }

            if ($cover && 'author-unknown' !== $model->slug) {
                $model->clearMediaCollection($disk->value);
                MediaService::create($model, $model->slug, $disk)
                    ->setMedia($cover)
                    ->setColor()
                ;
            }
        }

        return $model;
    }

    public static function setCoverPlaceholder(Author $author): Author
    {
        if ($author->getMedia(MediaDiskEnum::cover->value)->isEmpty()) {
            $placeholder = public_path('assets/images/no-author.webp');
            $disk = self::DISK;
            $author->clearMediaCollection($disk->value);
            MediaService::create($author, $author->slug, $disk)
                ->setMedia(base64_encode(File::get($placeholder)))
                ->setColor()
            ;
        }

        return $author;
    }

    /**
     * Generate Serie tags from Books relationship tags.
     */
    public static function setTags(Serie|Author $model): Serie|Author
    {
        $books = $model->books;
        $tags = [];
        foreach ($books as $key => $book) {
            foreach ($book->tags as $key => $tag) {
                array_push($tags, $tag);
            }
        }

        $model->syncTags($tags);
        $model->save();

        return $model;
    }
}
