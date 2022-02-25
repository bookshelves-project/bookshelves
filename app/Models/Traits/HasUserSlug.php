<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait HasUserSlug
{
    /**
     * Generate a slug for Model.
     *
     * @param mixed  $model     instance of current model
     * @param string $attribute linked to slug like `title`
     * @param bool   $with_tag  add a random number tag to allow model to have same $attribute with different `slug`
     */
    public static function generateSlug(mixed $model, string $attribute, bool $with_tag = false): string
    {
        $id = $with_tag ? self::generateId() : null;

        $slug_name = Str::slug($model->{$attribute}, '-');
        $slug = $slug_name.$id;
        $exist = $model::whereSlug($slug)->first();

        while ($exist) {
            $id = $with_tag ? self::generateId() : null;
            $slug = $slug_name.$id;
        }

        return $slug;
    }

    public static function generateId(): string
    {
        $id = rand(1000, 9999);

        return '-'.$id;
    }

    /**
     * Check if attribute link to slug is updated.
     *
     * @param string $attribute in Model, like `title` or `name`
     * @param string $value     new value for previous attibute from Request
     * @param bool   $with_tag  add a random number tag to allow model to have same $attribute with different `slug`
     */
    public function slugAttributeIsUpdated(string $attribute, string $value, bool $with_tag = false): string
    {
        $slug = $this->slug;

        if ($this->{$attribute} !== $value) {
            $find_id = explode('-', $slug);
            $id = end($find_id);

            $new_slug = Str::slug($value, '-').'-'.$id;
            $exist = get_class($this)::whereSlug($new_slug)->first();

            if ($exist) {
                $new_slug = self::generateSlug($this, 'name', $with_tag);
            }
            $this->slug = $new_slug;

            $this->save();

            return $new_slug;
        }

        return $slug;
    }
}
