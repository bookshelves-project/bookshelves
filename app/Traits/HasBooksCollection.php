<?php

namespace App\Traits;

use App\Enums\BookFormatEnum;
use App\Models\Author;
use App\Models\Serie;
use Kiwilan\Steward\Class\DownloadFile;

trait HasBooksCollection
{
    public function getFileMainAttribute(): ?DownloadFile
    {
        if (empty($this->files_list)) {
            return null;
        }

        return current(array_filter(array_reverse($this->files_list)));
    }

    public function getFilesListAttribute(): array
    {
        $entity = $this->classNamespaced()::whereSlug($this->slug)
            ->with('books.media')
            ->first()
        ;

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
            $route = $this->getDownloadLinkFormat($format);
            $list[$format] = null;

            if ($size['size']) {
                $size_human = $size['size'] > 0 ? $this->humanFilesize($size['size']) : null;
                $download = new DownloadFile($entity->slug, $size_human, $route, null, $format, $size['count'], true);
                $list[$format] = $download;
            }
        }

        return $list;
    }

    public function humanFilesize(string|int $bytes, ?int $decimals = 2): string
    {
        $sz = [
            'B',
            'Ko',
            'Mo',
            'Go',
            'To',
            'Po',
        ];
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)).' '.@$sz[$factor];
    }
}
