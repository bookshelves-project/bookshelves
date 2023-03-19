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
        // $this->fillable[] = $this->getUsernameColumn();
    }

    public function getUsernameWith(): string
    {
        return $this->username_with ?? $this->default_username_with;
    }

    public function getUsernameColumn(): string
    {
        return $this->username_column ?? $this->default_username_column;
    }

    /**
     * Generate a username for Model.
     */
    public function generateUsername(): string
    {
        $tag = rand(1000, 9999);
        $username_name = Str::slug($this->{$this->getUsernameWith()}, '-');
        $username = "{$username_name}-{$tag}";

        $exist = $this::where($this->getUsernameColumn(), $username)->first();

        while ($exist) {
            $tag = $this->generateUsername();
            $username_name = Str::slug($this->{$this->getUsernameWith()}, '-');
            $username = "{$username_name}-{$tag}";
        }

        return $username;
    }

    /**
     * Check if attribute link to username is updated.
     *
     * @param  string  $attribute in Model, like `title` or `name`
     * @param  string  $value     new value for previous attibute from Request
     * @param  bool  $with_tag  add a random number tag to allow model to have same $attribute with different `username`
     */
    public function usernameAttributeIsUpdated(string $attribute, string $value, bool $with_tag = true): string
    {
        $username = $this->username;

        if ($this->{$attribute} !== $value) {
            $find_id = explode('-', $username);
            $id = end($find_id);

            $new_username = Str::slug($value, '-').'-'.$id;
            $exist = get_class($this)::where($this->getUsernameColumn(), $new_username)->first();

            if ($exist) {
                $new_username = $this->generateUsername();
            }
            $this->username = $new_username;

            $this->save();

            return $new_username;
        }

        return $username;
    }

    protected static function bootHasUsername()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getUsernameColumn()})) {
                $model->{$model->getUsernameColumn()} = $model->generateUsername();
            }
        });
    }
}
