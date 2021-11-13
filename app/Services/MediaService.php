<?php

namespace App\Services;

use App\Enums\SpatieMediaMethodEnum;
use Illuminate\Database\Eloquent\Model;

class MediaService
{
    public function __construct(
        public Model $model,
        public string $name,
        public string $disk,
        public ?string $collection = null,
        public ?string $extension = null,
        public ?string $method = null,
    ) {
        $this->method = $this->method ? $this->method : SpatieMediaMethodEnum::addMediaFromBase64();
    }

    public function setMedia(string $data)
    {
        $extension = $this->extension;
        if (! $this->extension) {
            $extension = config('bookshelves.cover_extension');
        }
        $collection = $this->collection;
        if (! $this->collection) {
            $collection = $this->disk;
        }
        $method = $this->method;
        $this->model->{$method}($data)
            ->setName($this->name)
            ->setFileName($this->name.'.'.$extension)
            ->toMediaCollection($collection, $this->disk)
        ;
        $this->model->refresh();
    }

    public function setColor()
    {
        if (! $this->collection) {
            $collection = $this->disk;
        }
        // @phpstan-ignore-next-line
        $image = $this->model->getFirstMediaPath($collection);

        $color = ImageService::simple_color_thief($image);
        // @phpstan-ignore-next-line
        $media = $this->model->getFirstMedia($collection);
        $media->setCustomProperty('color', $color);
        $media->save();
    }
}
