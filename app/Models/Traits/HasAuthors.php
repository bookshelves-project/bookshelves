<?php

namespace App\Models\Traits;

use App\Models\Author;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Get authors
 * - with author for meta
 * - a string with all authors seperated by a comma
 * - API links: `show`, `show-opds`, `download-link`,`webreader-link`
 */
trait HasAuthors
{
    /**
     * Get first Author of entity, used for URL like `...author-slug/entity-slug`
     */
    public function getMetaAuthorAttribute(): string | null
    {
        $author = $this->authors->first();

        return $author->slug;
    }

    /**
     * Get Authors of entity
     */
    public function authors(): MorphToMany
    {
        return $this->morphToMany(Author::class, 'authorable');
    }

    public function getAuthorsNamesAttribute(): string
    {
        $authors = [];
        foreach ($this->authors as $key => $author) {
            array_push($authors, $author->name);
        }

        return implode(', ', $authors);
    }

    public function getShowLinkAttribute(): string
    {
        if ($this->meta_author && $this->slug) {
            $route = route('api.'.$this->getClassName(true).'.show', [
                'author'                => $this->meta_author,
                $this->getClassName()   => $this->slug,
            ]);

            return $route;
        }

        return '';
    }

    public function getShowLinkOpdsAttribute(): string
    {
        $route = route('opds.'.$this->getClassName(true).'.show', [
            'version'               => 'v1.2',
            'author'                => $this->meta_author,
            $this->getClassName()   => $this->slug,
        ]);

        return $route;
    }

    public function getDownloadLinkAttribute(): string
    {
        $route = route('api.download.'.$this->getClassName(), [
            'author'                => $this->meta_author,
            $this->getClassName()   => $this->slug,
        ]);

        return $route;
    }

    public function getWebreaderLinkAttribute(): string
    {
        if ($this->meta_author && $this->slug) {
            $route = route('webreader.cover', [
                'author'                => $this->meta_author,
                $this->getClassName()   => $this->slug,
            ]);

            return $route;
        }

        return '';
    }
}
