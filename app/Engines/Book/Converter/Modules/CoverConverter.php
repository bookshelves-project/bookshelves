<?php

namespace App\Engines\Book\Converter\Modules;

use App\Enums\MediaDiskEnum;
use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Kiwilan\Ebook\Ebook;
use Kiwilan\Steward\Enums\SpatieMediaMethodEnum;
use Kiwilan\Steward\Services\DirectoryService;
use Kiwilan\Steward\Services\MediaService;
use ReflectionClass;
use Spatie\Image\Image;
use Storage;

class CoverConverter
{
    /**
     * Generate Book image from original cover string file.
     * Manage by spatie/laravel-medialibrary.
     */
    public static function make(Ebook $ebook, Book $book): Book
    {
        $self = new self();

        if (! $ebook->hasCover()) {
            Log::warning("No cover for {$book->title}");

            return $book;
        }

        $content = $ebook->cover()->content();
        $temp_file = $self->resize($content);

        if (file_exists($temp_file)) {
            MediaService::make($book, $book->slug, MediaDiskEnum::cover, method: SpatieMediaMethodEnum::addMediaFromString)
                ->setMedia(file_get_contents($temp_file))
                ->setColor()
            ;

            unlink($temp_file);
        }

        return $book;
    }

    /**
     * Resize image to 800px height and create temp file.
     *
     * @return string Path to temp file.
     */
    protected function resizeSpatie(string $content, int $newHeight = 800): string
    {
        $temp_path = storage_path('app/public/cache');
        $temp_name = uniqid().'.jpg';
        $temp_file = "{$temp_path}/{$temp_name}";

        $resize_name = explode('.', $temp_name);
        $resize_name = "{$resize_name[0]}_resize.{$resize_name[1]}";
        $resize_file = "{$temp_path}/{$resize_name}";

        file_put_contents($temp_file, $content);

        Image::load($temp_file) // @phpstan-ignore-line
            ->height($newHeight)
            ->save($resize_file)
        ;

        unlink($temp_file);

        return $resize_file;
    }

    protected function resize(string $content, int $newHeight = 800): string
    {
        header('Content-Type: image/jpeg');

        if (base64_decode($content, true) !== false) {
            $content = base64_decode($content);
        }

        $stream = imagecreatefromstring($content);
        $width = imagesx($stream);
        $height = imagesy($stream);

        $newHeight = 800;
        $newWidth = intval($width / $height * $newHeight);

        $image = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresized($image, $stream, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        $temp_path = storage_path('app/public/cache');
        $temp_name = uniqid().'.jpg';
        $temp_file = "{$temp_path}/{$temp_name}";

        imagejpeg($image, $temp_file, 80);

        return $temp_file;
    }

    /**
     * Generate Serie image from `public/storage/data/[model_name]s` if JPG file with `Author`|`Serie` `slug` exist.
     */
    public static function getLocal(Author|Serie $model): ?string
    {
        $class = new ReflectionClass($model::class);
        $class = $class->getShortName();
        $model_name = strtolower($class);
        $path = storage_path("app/public/data/{$model_name}s");
        $cover = null;

        $files = DirectoryService::make()->parse($path);

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_FILENAME) === $model->slug) {
                $cover = base64_encode(file_get_contents($file));
            }
        }

        return $cover;
    }

    /**
     * Set local cover if exist.
     */
    public static function setLocalCover(Author|Serie $model): Serie|Author
    {
        $disk = MediaDiskEnum::cover;
        $local_cover = self::getLocal($model);

        if ($model instanceof Serie) {
            SerieConverter::setBookCover($model);
        }

        if ($local_cover) {
            $model->clearMediaCollection($disk->value);
            MediaService::make($model, $model->slug, $disk)
                ->setMedia($local_cover)
                ->setColor()
            ;

            $model->save();
        }

        return $model;
    }
}
