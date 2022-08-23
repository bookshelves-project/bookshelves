<?php

namespace App\Traits;

trait HasSeo
{
    protected $default_meta_title_from = 'name';

    protected $default_meta_description_from = 'description';

    public function initializeHasSEO()
    {
        $this->fillable[] = 'meta_title';
        $this->fillable[] = 'meta_description';
    }

    public static function bootHasSEO()
    {
        static::creating(function ($model) {
            if (empty($model->meta_title)) {
                $model->meta_title = $model->{$model->getMetaTitle()};
            }
            if (empty($model->meta_description)) {
                $model->meta_description = $model->{$model->getMetaDescription()};
            }
        });
    }

    public function getMetaTitle(): string
    {
        return $this->meta_title_from ?? $this->default_meta_title_from;
    }

    public function getMetaDescription(): string
    {
        return $this->meta_description_from ?? $this->default_meta_description_from;
    }

    public function getSeoAttribute(): array
    {
        return [
            'title' => $this->meta_title,
            'description' => $this->meta_description,
        ];
    }
}
