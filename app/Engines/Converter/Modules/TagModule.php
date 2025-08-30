<?php

namespace App\Engines\Converter\Modules;

use App\Enums\TagTypeEnum;
use App\Facades\Bookshelves;
use App\Models\Tag;

class TagModule
{
    public static function make(string $tag): ?Tag
    {
        $exists = Tag::where('name', $tag)->first();
        if ($exists) {
            return $exists;
        }

        $mainGenres = Bookshelves::tagsGenreList();
        $tag = str_replace(' and ', ' & ', $tag);
        $tag = str_replace('-', ' ', $tag);
        $forbiddenTags = Bookshelves::tagsForbiddenList();
        $convertedTags = Bookshelves::tagsConvertedList();

        foreach ($convertedTags as $key => $convertedTag) {
            if ($tag === $key) {
                $tag = $convertedTag;
            }
        }

        $model = null;

        if ($tag !== null && strlen($tag) > 1 && strlen($tag) < 30 && ! in_array($tag, $forbiddenTags)) {
            $tag = strtolower($tag);
            $tag = ucfirst($tag);

            $model = Tag::firstOrCreate([
                'name' => $tag,
            ]);

            if (in_array($tag, $mainGenres)) {
                $model->type = TagTypeEnum::genre;
            } else {
                $model->type = TagTypeEnum::tag;
            }
            $model->save();
        }

        return $model;
    }
}
