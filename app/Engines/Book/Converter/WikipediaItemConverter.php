<?php

namespace App\Engines\Book\Converter;

use App\Enums\MediaDiskEnum;
use App\Models\Author;
use App\Models\Serie;
use Illuminate\Support\Str;
use Kiwilan\Steward\Services\MediaService;
use Kiwilan\Steward\Services\Wikipedia\WikipediaItem;

/**
 * Class to convert item data into Model data.
 */
class WikipediaItemConverter
{
    public const DISK = MediaDiskEnum::cover;

    public function __construct(
        public WikipediaItem $item,
        public Author|Serie|null $model = null,
    ) {
    }

    public static function make(WikipediaItem $item, Author|Serie $model): self
    {
        $self = new WikipediaItemConverter($item);
        $self->model = $model;

        return $self;
    }

    public function setWikipediaDescription(): self
    {
        if (! $this->model->description && ! $this->model->link) {
            // if ('' === $model->getTranslation('description', $model->language_slug)) {
            //     $model->setTranslation(
            //         'description',
            //         $model->language_slug,
            //         Str::limit($model->item->extract, 1000)
            //     );
            // }
            $this->model->description = Str::limit($this->item->getExtract(), 1000); // TODO translatable
            $this->model->link = $this->item->getFullUrl();
            $this->model->save();
        }
        $entityConverter = EntityConverter::make($this->model);
        $entityConverter->parseLocalData();

        return $this;
    }

    public function setWikipediaCover(): self
    {
        $disk = MediaDiskEnum::cover;

        if (! $this->model->getMedia($disk->value)->isEmpty()) {
            return $this;
        }

        $cover = null;

        if ($this->model->link) {
            $cover = WikipediaItem::fetchPicture($this->item->getPictureUrl());
        }

        if ($cover && 'author-unknown' !== $this->model->slug) {
            $this->model->clearMediaCollection($disk->value);
            MediaService::make($this->model, $this->model->slug, $disk)
                ->setMedia($cover)
                ->setColor()
            ;
        }

        return $this;
    }
}
