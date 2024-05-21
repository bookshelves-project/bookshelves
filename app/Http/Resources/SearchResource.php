<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Author|\App\Models\Book|\App\Models\Serie $resource
 */
class SearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $class = null;
        $count = null;
        if ($this->resource instanceof \App\Models\Author) {
            $class = 'Author';
            $this->resource->loadMissing([
                'media',
                'books',
            ])->loadCount('books');
            $count = $this->resource->books_count;
        }

        if ($this->resource instanceof \App\Models\Book) {
            $class = 'Book';
            $this->resource->loadMissing([
                'authors',
                'language',
                'library',
                'serie',
                'media',
            ]);
        }

        if ($this->resource instanceof \App\Models\Serie) {
            $class = 'Serie';
            $this->resource->loadMissing([
                'authors',
                'language',
                'library',
                'media',
            ])->loadCount('books');
            $count = $this->resource->books_count;
        }

        return [
            'title' => $this->resource->title,
            'slug' => $this->resource->slug,
            'library' => $this->toLibrary(),
            'class' => $class,
            'authors' => $this->toAuthors(),
            'serie' => $this->toSerie(),
            'volume' => $this->resource->volume_pad ?? null,
            'language' => $this->toLanguage(),
            'count' => $count,
            'cover_thumbnail' => $this->resource->cover_thumbnail,
            'cover_color' => $this->resource->cover_color,
            'route' => $this->resource->route,
        ];
    }

    private function toLibrary(): ?array
    {
        if (! $this->resource->library) {
            return null;
        }

        return [
            'name' => $this->resource->library->name,
            'type' => $this->resource->library->type,
        ];
    }

    private function toAuthors(): ?array
    {
        /** @var Model */
        $model = $this->resource;
        if (! $model->relationLoaded('authors')) {
            return null;
        }

        if ($this->resource->authors->isEmpty()) {
            return null;
        }

        return $this->resource->authors->map(fn ($author) => [
            'name' => $author->name,
        ])->toArray();
    }

    private function toSerie(): ?array
    {
        if (! $this->resource->serie) {
            return null;
        }

        return [
            'title' => $this->resource->serie->title,
        ];
    }

    private function toLanguage(): ?array
    {
        if (! $this->resource->language) {
            return null;
        }

        return [
            'name' => $this->resource->language->name,
        ];
    }
}
