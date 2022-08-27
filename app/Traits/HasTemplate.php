<?php

namespace App\Traits;

use App\Enums\MediaDiskEnum;
use App\Enums\TemplateEnum;

trait HasTemplate
{
    protected $default_template_column = 'content';

    public function initializeHasTemplate()
    {
        $this->fillable[] = 'template';

        $this->casts['template'] = TemplateEnum::class;
    }

    public function getTemplateColumn(): string
    {
        return $this->template_column ?? $this->default_template_column;
    }

    public function getTemplateTransformAttribute(): ?array
    {
        if (is_array($this->{$this->getTemplateColumn()})) {
            $data = [];
            foreach ($this->{$this->getTemplateColumn()} as $value) {
                $this->transformData($value, $data);
            }

            return $this->setMedia($data);
        }

        return [];
    }

    private function transformData(mixed $data, array &$page_data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $is_list = false;
                if ('list' === $key) {
                    $is_list = true;
                }

                if (! $is_list && is_array($value) && array_key_exists(0, $value)) {
                    $value = $value[0];
                    $page_data[$key] = $value;
                }

                $this->transformData($value, $page_data);
            }
        }
    }

    private function setMedia(array $data)
    {
        $json = json_encode($data);

        $regex = preg_replace_callback('"cms"', function ($replaced) {
            $media_disk = MediaDiskEnum::cms->value;
            return config('app.url')."/storage/{$media_disk}";
        }, $json);

        return json_decode($regex, true);
    }
}
