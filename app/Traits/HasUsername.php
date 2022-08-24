<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUsername
{
    protected $default_username_with = 'name';

    protected $default_username_column = 'username';

    public function initializeHasUsername()
    {
        $this->fillable[] = $this->getUsernameColumn();
    }

    public function getUsernameWith(): string
    {
        return $this->username_with ?? $this->default_username_with;
    }

    public function getUsernameColumn(): string
    {
        return $this->username_column ?? $this->default_username_column;
    }

    protected static function bootHasUsername()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getUsernameColumn()})) {
                $model->{$model->getUsernameColumn()} =
                    $model->generateUsername($model, $model->{$model->getUsernameWith()}, true);
            }
        });
    }

    /**
     * Generate a username for Model.
     *
     * @param  mixed  $model     instance of current model
     * @param  string  $attribute linked to username like `title`
     * @param  bool  $with_tag  add a random number tag to allow model to have same $attribute with different `username`
     */
    public static function generateUsername(Model $model, string $attribute, bool $with_tag = false): string
    {
        $id = $with_tag ? self::generateId() : null;

        $username_name = Str::slug($model->{$attribute}, '-');
        $username = $username_name.$id;
        $exist = $model::where($model->getUsernameColumn(), $username)->first();

        while ($exist) {
            $id = $with_tag ? self::generateId() : null;
            $username = $username_name.$id;
        }

        return $username;
    }

    public static function generateId(): string
    {
        $id = rand(1000, 9999);

        return '-'.$id;
    }

    /**
     * Check if attribute link to username is updated.
     *
     * @param  string  $attribute in Model, like `title` or `name`
     * @param  string  $value     new value for previous attibute from Request
     * @param  bool  $with_tag  add a random number tag to allow model to have same $attribute with different `username`
     */
    public function usernameAttributeIsUpdated(string $attribute, string $value, bool $with_tag = false): string
    {
        $username = $this->username;

        if ($this->{$attribute} !== $value) {
            $find_id = explode('-', $username);
            $id = end($find_id);

            $new_username = Str::slug($value, '-').'-'.$id;
            $exist = get_class($this)::where($this->getUsernameColumn(), $new_username)->first();

            if ($exist) {
                $new_username = $this->generateUsername($this, $this->getUsernameWith(), $with_tag);
            }
            $this->username = $new_username;

            $this->save();

            return $new_username;
        }

        return $username;
    }
}
