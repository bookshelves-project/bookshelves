<?php

namespace App\Traits;

use App\Enums\BookFormatEnum;
use App\Models\Author;
use App\Models\Serie;
use Kiwilan\Steward\Utils\DownloadFile;
use Kiwilan\Steward\Utils\FileSize;

trait HasBooksCollection
{
    public function getFileMainAttribute(): ?DownloadFile
    {
        $file_list = collect($this->files_list);

        if ($file_list->isEmpty()) {
            return null;
        }

        return $file_list
            ->reverse()
            ->filter(fn ($file) => $file !== null)
            ->first();
    }

    public function getFilesListAttribute(): array
    {
        $entity = $this->meta_class_namespaced::whereSlug($this->slug)
            ->with('books.media')
            ->first();

        return $this->getSizesList($entity);
    }

    public function getSizesList(Author|Serie $entity): array
    {
        $sizes = [];
        $formats = BookFormatEnum::toValues();

        foreach ($formats as $format) {
            $sizes[$format] = [
                'size' => 0,
                'count' => 0,
            ];

            foreach ($entity->books as $book) {
                $media = $book->files[$format];
                // @phpstan-ignore-next-line
                $sizes[$format]['size'] += $media?->size;

                // @phpstan-ignore-next-line
                if ($media?->size) {
                    $sizes[$format]['count']++;
                }
            }
        }

        $list = [];

        foreach ($sizes as $format => $size) {
            $route = null;

            if (method_exists($this, 'getDownloadLinkFormat')) {
                $route = $this->getDownloadLinkFormat($format);
            }
            $list[$format] = null;

            if ($size['size']) {
                $size_human = $size['size'] > 0 ? FileSize::humanReadable($size['size']) : null;
                $download = new DownloadFile(
                    name: $entity->slug,
                    size: $size_human,
                    url: $route,
                    format: $format,
                    count: $size['count'],
                    isZip: true,
                );
                $list[$format] = $download;
            }
        }

        return $list;
    }
}
