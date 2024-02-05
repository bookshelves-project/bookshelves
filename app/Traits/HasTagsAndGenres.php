<?php

namespace App\Traits;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait HasTagsAndGenres
{
    /**
     * Scope a query to only include records with any of the given tags.
     *
     * @param  Collection<int, Tag>  $tags
     */
    public function scopeWithAllTags(Builder $query, Collection $tags): Builder
    {
        $ids = [];
        foreach ($tags as $tag) {
            $ids[] = $tag->id;
        }
        $ids = array_unique($ids);
        $ids = array_values($ids);

        return $query->whereHas(
            'tags',
            function (Builder $query) use ($ids) {
                $query->select(DB::raw('count(distinct id)'))->whereIn('id', $ids);
            },
            '=',
            count($ids)
        );
    }

    /**
     * Scope a query to only include records with all of the given tags.
     */
    public function scopeWhereTagsAllIs(Builder $query, iterable ...$tags): Builder
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

    /**
     * Scope a query to only include records with any of the given tags.
     */
    public function scopeWhereTagsIs(Builder $query, iterable ...$tags): Builder
    {
        return $query->whereHas('tags', function (Builder $q) use ($tags) {
            $q->whereIn('slug', $tags);
        });
    }

    /**
     * Get tags as string.
     */
    public function getTagsStringAttribute(): string
    {
        $tags = $this->tags()->get();

        /** @var string[] $tag_names */
        $tag_names = $tags->map(fn (Tag $tag) => $tag->name)->toArray();

        return implode(', ', $tag_names);
    }

    /**
     * Get only tags.
     *
     * @return Collection<int, Tag>
     */
    public function getTagsListAttribute(): Collection
    {
        return $this->tags()->whereType('tag')->get();
    }

    /**
     * Get only genres.
     *
     * @return Collection<int, Tag>
     */
    public function getGenresListAttribute(): Collection
    {
        return $this->tags()->whereType('genre')->get();
    }

    public function tags(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this
            ->morphToMany(Tag::class, 'taggable', 'taggables', null, 'tag_id')
            ->orderBy('order_column');
    }

    /**
     * Sync tags list.
     */
    public function syncTagsList(iterable $tags): static
    {
        $items = collect();

        foreach ($tags as $name) {
            $tag = Tag::query()->where('name', $name)
                ->first();

            if (! $tag) {
                $tag = Tag::query()->create([
                    'name' => $name,
                ]);
            }
            $items->add($tag);
        }

        $this->tags()->sync($items->pluck('id')->toArray());

        return $this;
    }
}
