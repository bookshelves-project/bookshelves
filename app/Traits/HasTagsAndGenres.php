<?php

namespace App\Traits;

use App\Models\Tag;
use ArrayAccess;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\DB;

trait HasTagsAndGenres
{
    public function scopeWithAllTags(Builder $query, ...$tags)
    {
        $tags_ids = [];

        foreach ($tags as $tag) {
            $tag_model = Tag::query()->where('slug', $tag)->first();
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

    public function scopeWhereTagsAllIs(Builder $query, ...$tags)
    {
        $tags_ids = [];

        foreach ($tags as $tag) {
            $tag_model = Tag::query()->where('slug', $tag)->first();
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
            $q->whereIn('slug', $tags);
        });
    }

    public function getTagsStringAttribute(): string
    {
        $tags = $this->tags()->get();

        /** @var string[] $tag_names */
        $tag_names = $tags->map(fn (Tag $tag) => $tag->name)->toArray();

        return implode(', ', $tag_names);
    }

    public function getTagsListAttribute()
    {
        return $this->tags()->whereType('tag')->get();
    }

    public function getGenresListAttribute()
    {
        return $this->tags()->whereType('genre')->get();
    }

    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(Tag::class, 'taggable', 'taggables', null, 'tag_id')
            ->orderBy('order_column');
    }

    public function syncTagsList(array|ArrayAccess $tags): static
    {
        $tags_list = collect();

        foreach ($tags as $name) {
            $tag = Tag::query()->where('name', $name)
                ->first();

            if (! $tag) {
                $tag = Tag::query()->create([
                    'name' => $name,
                ]);
            }
            $tags_list->add($tag);
        }

        $this->tags()->sync($tags_list->pluck('id')->toArray());

        return $this;
    }
}
