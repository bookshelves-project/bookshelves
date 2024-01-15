<?php

namespace App\Engines\Book\Converter;

use App\Enums\MediaDiskEnum;
use App\Models\Author;
use App\Models\Serie;
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
        public Serie|Author $model,
        public ReflectionClass $reflect,
        public array $local = [],
        public ?string $localPath = null,
    ) {
    }

    public static function make(Serie|Author $model): self
    {
        $reflect = new ReflectionClass($model);

        return new EntityConverter(
            model: $model,
            reflect: $reflect,
        );
    }

    /**
     * Improve model with local data into JSON.
     */
    public function parseLocalData(): self
    {
        $name = strtolower($this->reflect->getShortName());
        $path = public_path("storage/data/{$name}s/{$name}s.json");

        if (! File::exists($path)) {
            return $this;
        }

        $this->localPath = $path;
        $json = json_decode(File::get($this->localPath));
        $data = ConverterService::objectToArray($json);

        if (array_key_exists($this->model->slug, $data)) {
            $this->local = $data[$this->model->slug];
        }

        if (array_key_exists($this->model->slug_sort, $data)) {
            $this->local = $data[$this->model->slug_sort];
        }

        if (! $this->local) {
            return $this;
        }

        $this->model->description = array_key_exists('description', $this->local)
            ? $this->local['description']
            : null;

        $this->model->link = array_key_exists('link', $this->local)
            ? $this->local['link']
            : null;

        $this->model->note = array_key_exists('note', $this->local)
            ? $this->local['note']
            : null;

        $this->model->save();

        return $this;
    }

    /**
     * Set cover placeholder if no cover.
     */
    public function setCoverPlaceholder(): self
    {
        if ($this->model->getMedia(MediaDiskEnum::cover->value)->isEmpty()) {
            $placeholder = public_path('vendor/images/no-author.webp');
            $disk = self::DISK;
            $this->model->clearMediaCollection($disk->value);
            MediaService::make($this->model, $this->model->slug, $disk)
                ->setMedia(base64_encode(File::get($placeholder)))
                ->setColor();
        }

        return $this;
    }

    /**
     * Generate Serie tags from Books relationship tags.
     */
    public function setTags(): self
    {
        $books = $this->model->load('books.tags')->books;
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
