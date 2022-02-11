<?php

namespace App\Models\Traits;

use App\Models\TagExtend;
use ArrayAccess;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Spatie\Tags\Tag;

/**
 * Manage tags and genres with `spatie/laravel-tags`.
 */
trait HasTagsAndGenres
{
    public function scopeWhereTagsAllIs(Builder $query, ...$tags)
    {
        $tags_ids = [];
        foreach ($tags as $tag) {
            $tag_model = Tag::where('slug->en', $tag)->first();
            $id = $tag_model?->id;
            if ($id) {
                array_push($tags_ids, $id);
            }
        }

        return $query->whereHas(
            'tags',
            function (Builder $query) use ($tags_ids) {
                $query->select(DB::raw('count(distinct id)'))->whereIn('id', $tags_ids);
            },
            '=',
            count($tags_ids)
        );
    }

    public function scopeWhereTagsIs(Builder $query, ...$tags)
    {
        return $query->whereHas('tags', function (Builder $q) use ($tags) {
            $q->whereIn('slug->en', $tags);
        });
    }

    public function getTagsListAttribute()
    {
        return $this->tags()->whereType('tag')->get();
    }

    public function getGenresListAttribute()
    {
        return $this->tags()->whereType('genre')->get();
    }

    public function syncTagsList(array|ArrayAccess $tags): static
    {
        $tags_list = collect();
        foreach ($tags as $name) {
            $tag = TagExtend::whereNameEnIs($name)->first();
            if (! $tag) {
                $tag = TagExtend::create([
                    'name' => $name,
                ]);
            }
            $tags_list->add($tag);
        }

        $this->tags()->sync($tags_list->pluck('id')->toArray());

        return $this;
    }
}
