<?php

namespace App\Engines\ConverterEngine;

use App\Enums\MediaDiskEnum;
use App\Models\Author;
use App\Models\Serie;
use Illuminate\Support\Str;
use Kiwilan\Steward\Class\WikipediaItem;
use Kiwilan\Steward\Services\MediaService;
use Kiwilan\Steward\Services\WikipediaService\WikipediaQuery;

/**
 * Class to convert wikipedia_item data into Model data.
 *
 * @property WikipediaItem $wikipedia_item
 * @property Author|Serie  $model
 */
class WikipediaItemConverter
{
    public const DISK = MediaDiskEnum::cover;

    public function __construct(
        public WikipediaItem $wikipedia_item,
        public mixed $model = null,
    ) {
    }

    public static function make(WikipediaItem $wikipedia_item): self
    {
        $wikipedia_item_converter = new WikipediaItemConverter($wikipedia_item);
        $wikipedia_item_converter->setModel();

        return $wikipedia_item_converter;
    }

    public function setModel(): self
    {
        $this->model = $this->wikipedia_item->model_name::find($this->wikipedia_item->model_id);

        return $this;
    }

    public function setWikipediaDescription(): self
    {
        if (!$this->model->description && !$this->model->link) {
            // if ('' === $model->getTranslation('description', $model->language_slug)) {
            //     $model->setTranslation(
            //         'description',
            //         $model->language_slug,
            //         Str::limit($model->wikipedia_item->extract, 1000)
            //     );
            // }
            $this->model->description = Str::limit($this->wikipedia_item->extract, 1000); // TODO translatable
            $this->model->link = $this->wikipedia_item->page_url;
            $this->model->save();
        }
        $entity_conveter = EntityConverter::make($this->model);
        $entity_conveter->parseJson();

        return $this;
    }

    public function setWikipediaCover(): self
    {
        $disk = MediaDiskEnum::cover;
        if ($this->model->getMedia($disk->value)->isEmpty()) {
            $cover = null;
            if ($this->model->link) {
                $cover = WikipediaQuery::getPictureFile($this->wikipedia_item->picture_url);
            }

            if ($cover && 'author-unknown' !== $this->model->slug) {
                $this->model->clearMediaCollection($disk->value);
                MediaService::make($this->model, $this->model->slug, $disk)
                    ->setMedia($cover)
                    ->setColor();
            }
        }

        return $this;
    }
}
