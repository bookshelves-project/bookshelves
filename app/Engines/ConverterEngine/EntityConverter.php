<?php

namespace App\Engines\ConverterEngine;

use App\Class\WikipediaItem;
use App\Enums\MediaDiskEnum;
use App\Models\Author;
use App\Models\Serie;
use App\Services\ConverterService;
use App\Services\MediaService;
use App\Services\WikipediaService\WikipediaQuery;
use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use ReflectionClass;

/**
 * Class to convert WikipediaItem data into Model data.
 *
 * @property WikipediaItem $wikipediaItem
 * @property Author|Serie  $model
 */
class EntityConverter
{
    public const DISK = MediaDiskEnum::cover;

    public function __construct(
        public WikipediaItem $wikipediaItem,
        public mixed $model = null,
    ) {
    }

    public static function make(WikipediaItem $wikipediaItem): self
    {
        $converter = new EntityConverter($wikipediaItem);
        $converter->setModel();

        return $converter;
    }

    public function setModel(): self
    {
        $this->model = $this->wikipediaItem->model_name::find($this->wikipediaItem->model_id);

        return $this;
    }

    /**
     * Improve model with local data into JSON.
     */
    public static function parseJson(Serie|Author $model): Serie|Author
    {
        $subject = new ReflectionClass($model);
        $subject = strtolower($subject->getShortName());
        $path = public_path("storage/data/{$subject}s/{$subject}s.json");
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

    public function setWikipediaDescription(): self
    {
        if (! $this->model->description && ! $this->model->link) {
            // if ('' === $model->getTranslation('description', $model->language_slug)) {
            //     $model->setTranslation(
            //         'description',
            //         $model->language_slug,
            //         Str::limit($model->wikipediaItem->extract, 1000)
            //     );
            // }
            $this->model->description = Str::limit($this->wikipediaItem->extract, 1000); // TODO translatable
            $this->model->link = $this->wikipediaItem->page_url;
            $this->model->save();
        }
        EntityConverter::parseJson($this->model);

        return $this;
    }

    public function setWikipediaCover(): self
    {
        $disk = MediaDiskEnum::cover;
        if ($this->model->getMedia($disk->value)->isEmpty()) {
            $cover = null;
            if ($this->model->link) {
                $cover = WikipediaQuery::getPictureFile($this->wikipediaItem->picture_url);
            }

            if ($cover && 'author-unknown' !== $this->model->slug) {
                $this->model->clearMediaCollection($disk->value);
                MediaService::create($this->model, $this->model->slug, $disk)
                    ->setMedia($cover)
                    ->setColor()
                ;
            }
        }

        return $this;
    }

    public static function setCoverPlaceholder(Author $author): Author
    {
        if ($author->getMedia(MediaDiskEnum::cover->value)->isEmpty()) {
            $placeholder = public_path('vendor/images/no-author.webp');
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
