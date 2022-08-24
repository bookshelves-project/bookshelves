<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    protected $default_slug_with = 'name';

    protected $default_slug_column = 'slug';

    public function initializeHasSlug()
    {
        $this->fillable[] = $this->getUsernameColumn();
    }

    public function getUsernameWith(): string
    {
        return $this->slug_with ?? $this->default_slug_with;
    }

    public function getUsernameColumn(): string
    {
        return $this->slug_column ?? $this->default_slug_column;
    }

    protected static function bootHasSlug()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getUsernameColumn()})) {
                $model->{$model->getUsernameColumn()} = $model->generateUniqueUsername($model->{$model->getUsernameWith()}, 0, $model->getUsernameColumn());
            }
        });
    }

    protected function generateUniqueUsername(string $name, int $counter = 0, string $slug_field = 'slug'): string
    {
        $updated_name = 0 == $counter ? $name : $name.'-'.$counter;
        if (static::where($slug_field, Str::slug($updated_name))->exists()) {
            return $this->generateUniqueUsername($name, $counter + 1, $slug_field);
        }
        return Str::slug($updated_name);
    }
}
