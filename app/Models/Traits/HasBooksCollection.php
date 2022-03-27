<?php

namespace App\Models\Traits;

use App\Enums\BookFormatEnum;
use App\Models\Author;
use App\Models\Serie;

trait HasBooksCollection
{
    public function getSizesList(Author|Serie $entity): object
    {
        $sizes = [];
        foreach (BookFormatEnum::toValues() as $format) {
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
                    ++$sizes[$format]['count'];
                }
            }
        }

        $list = [];
        foreach ($sizes as $format => $size) {
            $route = $this->getDownloadLinkFormat($format);

            if ($size['size']) {
                $download = [
                    'name' => $entity->slug,
                    'size' => $size['size'] > 0 ? $this->humanFilesize($size['size']) : null,
                    'download' => $route,
                    'type' => "{$format} zip",
                    'count' => $size['count'],
                ];
                $list[$format] = $download;
                $list['main'] = $download;
            } else {
                $list[$format] = null;
            }
        }

        return json_decode(json_encode($list, JSON_FORCE_OBJECT));
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
