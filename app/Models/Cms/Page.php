<?php

namespace App\Models\Cms;

use App\Enums\MediaDiskEnum;
use App\Enums\TemplateEnum;
use App\Traits\HasSeo;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasSeo;

    protected $table = 'cms_pages';

    protected $fillable = [
        'title',
        'language',
        'template',
        'content',
    ];

    protected $casts = [
        'template' => TemplateEnum::class,
        'content' => 'array',
    ];

    public function getPageTransformAttribute(): ?array
    {
        $data = [];
        foreach ($this->content as $value) {
            $this->transformData($value, $data);
        }

        return $this->setMedia($data);
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
