<?php

namespace App\Traits;

use App\Enums\BookFormatEnum;
use App\Models\Book;
use App\Models\MediaExtended;
use Illuminate\Support\Collection;
use Kiwilan\Steward\Class\DownloadFile;

/**
 * Manager multiple formats for a book.
 */
trait HasBookFiles
{
    /**
     * Manage files with spatie/laravel-medialibrary.
     *
     * @return Collection<int, ?MediaExtended>
     */
    public function getFilesAttribute(): Collection
    {
        $files = [];

        /** @var Book */
        $that = $this;

        foreach (BookFormatEnum::toValues() as $format) {
            $files[$format] = $that->getMedia($format)
                ->first()
            ;
        }

        return MediaExtended::fromMedias($files);
    }

    /**
     * Manage files with spatie/laravel-medialibrary.
     *
     * @return MediaExtended[]
     */
    public function getFilesType(BookFormatEnum $format)
    {
        $files = [];

        foreach (BookFormatEnum::toValues() as $format) {
            $media = $this->getMedia($format)
                ->first(null, MediaExtended::class)
            ;
            $files[$format] = is_string($media) ? null : $media;
        }

        // @phpstan-ignore-next-line
        return $files;
    }

    public function getFileMainAttribute(): ?DownloadFile
    {
        if ($this->filesListIsNull()) {
            return null;
        }

        return $this->getFilesListAttribute()
            ->reverse()
            ->filter(fn ($file) => null !== $file)
            ->first()
        ;
    }

    public function filesListIsNull(): bool
    {
        return $this->files_list->filter(fn ($file) => null !== $file)->isEmpty();
    }

    /**
     * @return Collection<string, DownloadFile>
     */
    public function getFilesListAttribute(): Collection
    {
        $list = collect([]);
        $formats = BookFormatEnum::toValues();

        foreach ($formats as $format) {
            $media = null;

            if (null === $this->files[$format]) {
                $list[$format] = $media;

                continue;
            }

            $route = route('api.download.book', [
                'author_slug' => $this->meta_author,
                'book_slug' => $this->slug,
                'format' => $format,
            ]);

            /** @var MediaExtended $file */
            $file = $this->files[$format];
            $reader = route('webreader.reader', [
                'author' => $this->meta_author,
                $this->entity => $this->slug,
                'format' => $format,
            ]);

            $isZip = false;

            if (str_contains($file->mime_type, 'zip')) {
                $isZip = true;
            }

            $media = new DownloadFile(
                name: $file->file_name,
                size: $file->size_human,
                url: $route,
                reader: $reader,
                format: $file->extension,
                // count: $this->files[$format]->count(),
                isZip: $isZip,
            );

            $list[$format] = $media;
        }

        return $list;
    }
}
