<?php

namespace App\Traits;

use App\Enums\BookFormatEnum;
use App\Models\MediaExtended;
use Kiwilan\Steward\Class\DownloadFile;

/**
 * Manager multiple formats for a book.
 */
trait HasBookFiles
{
    /**
     * Manage files with spatie/laravel-medialibrary.
     *
     * @return MediaExtended[]|null[]
     */
    public function getFilesAttribute()
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

    public function getFileMainAttribute(): DownloadFile
    {
        return current(array_filter(array_reverse($this->files_list)));
    }

    /**
     * @return DownloadFile[]
     */
    public function getFilesListAttribute()
    {
        $list = [];
        $formats = BookFormatEnum::toValues();
        foreach ($formats as $format) {
            $media = null;
            if (null !== $this->files[$format]) {
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
                $media = new DownloadFile(
                    $file->file_name,
                    $file->size_human,
                    $route,
                    $reader,
                    $file->extension,
                );
            }
            $list[$format] = $media;
        }

        return $list;
    }
}
