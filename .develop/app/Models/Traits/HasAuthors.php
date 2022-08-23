<?php

namespace App\Models\Traits;

use App\Models\Author;
use ArrayAccess;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Get authors
 * - with author for meta
 * - a string with all authors seperated by a comma
 * - API links: `show`, `show-opds`, `download-link`,`webreader-link`.
 */
trait HasAuthors
{
    public function scopeWhereAuthorIsLike(Builder $query, string $author): Builder
    {
        return $query->whereHas('authors', function (Builder $query) use ($author) {
            $query->where('name', 'LIKE', "%{$author}%");
        });
    }

    /**
     * Get first Author of entity, used for URL like `...author-slug/entity-slug`.
     */
    public function getMetaAuthorAttribute(): string|null
    {
        $author = $this->authors->first();

        return $author->slug;
    }

    /**
     * Get main Author of entity.
     */
    public function getAuthorAttribute(): Author
    {
        return $this->authors->first();
    }

    /**
     * Get Authors of entity.
     */
    public function authors(): MorphToMany
    {
        return $this->morphToMany(Author::class, 'authorable');
    }

    public function getAuthorsNamesAttribute(): string
    {
        $authors = [];
        foreach ($this->authors as $key => $author) {
            array_push($authors, trim($author->name));
        }

        return implode(', ', $authors);
    }

    public function getShowLinkAttribute(): string
    {
        return route('api.'.$this->getClassName(true).'.show', [
            'author_slug' => $this->meta_author,
            "{$this->getClassName()}_slug" => $this->slug,
        ]);
    }

    public function getShowLinkOpdsAttribute(): string
    {
        return route('front.opds.'.$this->getClassName(true).'.show', [
            'version' => '1.2',
            'author' => $this->meta_author,
            $this->getClassName() => $this->slug,
        ]);
    }

    public function syncAuthors(array|ArrayAccess $authors): static
    {
        $authors_list = collect();
        foreach ($authors as $name) {
            $author = Author::whereName($name)->first();
            if (! $author) {
                $author = Author::create([
                    'name' => $name,
                ]);
            }
            $authors_list->add($author);
        }

        $this->authors()->sync($authors_list->pluck('id')->toArray());

        return $this;
    }
}
