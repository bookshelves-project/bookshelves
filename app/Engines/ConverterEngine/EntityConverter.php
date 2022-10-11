<?php

namespace App\Engines\ConverterEngine;

use App\Enums\MediaDiskEnum;
use App\Models\Author;
use App\Models\Serie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Kiwilan\Steward\Services\ConverterService;
use Kiwilan\Steward\Services\MediaService;
use ReflectionClass;

/**
 * Improve Author or Serie with additional data.
 *
 * @property Author|Serie $model
 */
class EntityConverter
{
    public const DISK = MediaDiskEnum::cover;

    public function __construct(
        public mixed $model = null,
    ) {
    }

    public static function make(Serie|Author $model): self
    {
        return new EntityConverter($model);
    }

    /**
     * Improve model with local data into JSON.
     */
    public function parseJson(): self
    {
        $subject = new ReflectionClass($this->model);
        $subject = strtolower($subject->getShortName());
        $path = public_path("storage/data/{$subject}s/{$subject}s.json");
        if (! File::exists($path)) {
            return $this;
        }

        $json = json_decode(File::get($path));
        $data = ConverterService::objectToArray($json);

        $local = null;
        if (array_key_exists($this->model->slug, $data)) {
            $local = $data[$this->model->slug];
        }
        if (array_key_exists($this->model->slug_sort, $data)) {
            $local = $data[$this->model->slug_sort];
        }
        if (null !== $local) {
            if (array_key_exists('description', $local)) {
                $this->model->description = $local['description'];
            }
            if (array_key_exists('link', $local)) {
                $this->model->link = $local['link'];
            }
            if (array_key_exists('note', $local)) {
                $this->model->note = $local['note'];
            }
            $this->model->save();
        }

        return $this;
    }

    public function setCoverPlaceholder(): self
    {
        if ($this->model->getMedia(MediaDiskEnum::cover->value)->isEmpty()) {
            $placeholder = public_path('vendor/images/no-author.webp');
            $disk = self::DISK;
            $this->model->clearMediaCollection($disk->value);
            MediaService::make($this->model, $this->model->slug, $disk)
                ->setMedia(base64_encode(File::get($placeholder)))
                ->setColor()
            ;
        }

        return $this;
    }

    /**
     * Generate Serie tags from Books relationship tags.
     */
    public function setTags(): self
    {
        $books = $this->model->books;
        $tags = [];
        foreach ($books as $key => $book) {
            foreach ($book->tags as $key => $tag) {
                array_push($tags, $tag);
            }
        }

        $this->model->syncTags($tags);
        $this->model->save();

        return $this;
    }
}
