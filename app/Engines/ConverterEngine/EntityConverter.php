<?php

namespace App\Engines\ConverterEngine;

use App\Engines\ParserEngine;
use App\Enums\MediaDiskEnum;
use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use App\Services\DirectoryParserService;
use App\Services\MediaService;
use App\Services\WikipediaService\WikipediaQuery;
use File;
use Illuminate\Support\Str;
use Storage;

class EntityConverter
{
    public const DISK = MediaDiskEnum::cover;

    public static function setWikipediaDescription(Serie|Author $model): Serie|Author
    {
        if ($model->wikipedia && ! $model->description && ! $model->link) {
            $model->description = Str::limit($model->wikipedia->extract, 1000);
            $model->link = $model->wikipedia->page_url;
            $model->save();
        }

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
            $placeholder = public_path('assets/images/no-author.jpg');
            $disk = self::DISK;
            $author->clearMediaCollection($disk->value);
            MediaService::create($author, $author->slug, $disk)
                ->setMedia(base64_encode(File::get($placeholder)))
                ->setColor()
            ;
        }

        return $author;
    }

    // public static function setLocalDescription(Serie $serie): ?Serie
    // {
    //     if (File::exists(public_path('storage/data/series/series.json'))) {
    //         $json = Storage::disk('public')->get('raw/series/series.json');
    //         $json = json_decode($json);
    //         foreach ($json as $key => $value) {
    //             if ($key === $serie->slug) {
    //                 $serie->description = $value->description;
    //                 $serie->link = $value->link;
    //                 $serie->save();

    //                 return $serie;
    //             }
    //         }

    //         return null;
    //     }

    //     return null;
    // }

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
