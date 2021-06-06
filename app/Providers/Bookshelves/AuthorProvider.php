<?php

namespace App\Providers\Bookshelves;

use File;
use Http;
use Storage;
use App\Models\Author;
use App\Utils\BookshelvesTools;
use App\Providers\MetadataExtractor\MetadataExtractorTools;

class AuthorProvider
{
    /**
     * Generate Author image & description.
     *
     * Generate description:
     * - from Wikipedia if found.
     *
     * Generate image:
     * - from `public/storage/raw/pictures-authors` if JPG file with author slug name exists
     * - from Wikipedia if found, managed by `spatie/laravel-medialibrary`
     * - if not use default image `database/seeders/media/authors/no-picture.jpg`
     */
    public static function descriptionAndPicture(Author $author, bool $alone, bool $no_cover): Author
    {
        $name = $author->name;
        $name = str_replace(' ', '%20', $name);
        $pageId = null;

        if (! $alone) {
            $pageId = self::wikipediaPageId($name);
            $result = self::localDescription($author);
            if (! $result) {
                $author = self::description($author, $pageId);
            }
            if (! $no_cover) {
                $author = self::picture($author, $pageId);
            }
        } else {
            $author = self::localDescription($author);
            if (! $no_cover) {
                $author = self::localPicture($author);
            }
        }

        $author = $author->refresh();

        return $author;
    }

    public static function wikipediaPageId(string $name): string | null
    {
        $pageId = null;
        $url = "https://en.wikipedia.org/w/api.php?action=query&list=search&srsearch=$name&format=json";

        try {
            $response = Http::get($url);
            $response = $response->json();
            $search = $response['query']['search'];
            $search = array_slice($search, 0, 5);
            foreach ($search as $key => $result) {
                if (strpos($result['title'], '(writer)')) {
                    $pageId = $result['pageid'];

                    break;
                }
            }
            if (! $pageId && array_key_exists(0, $search)) {
                $pageId = $search[0]['pageid'];
            }
        } catch (\Throwable $th) {
        }

        return $pageId;
    }

    public static function localDescription(Author $author): Author | null
    {
        if (File::exists(public_path('storage/raw/authors.json'))) {
            $json = Storage::disk('public')->get('raw/authors.json');
            $json = json_decode($json);
            foreach ($json as $key => $value) {
                if ($key === $author->slug) {
                    $author->description = $value->description ?? null;
                    $author->link = $value->link ?? null;
                    $author->note = $value->note ?? null;
                    $author->save();

                    return $author;
                }
            }

            return null;
        }

        return null;
    }

    public static function description(Author $author, string $pageId): Author
    {
        $url = "http://en.wikipedia.org/w/api.php?action=query&prop=info&pageids=$pageId&inprop=url&format=json&prop=info|extracts&inprop=url";
        $desc = null;

        try {
            $response = Http::get($url);
            $response = $response->json();
            $desc = $response['query']['pages'];
            $desc = reset($desc);
            $url = $desc['fullurl'];
            $desc = $desc['extract'];
            $desc = BookshelvesTools::stringLimit($desc, 500);
        } catch (\Throwable $th) {
        }
        if (is_string($desc)) {
            $author->description = "$desc";
            $author->link = $url;
            $author->save();
        }

        return $author;
    }

    /**
     * Get local picture from `public/storage/raw/pictures-authors`
     * Only JPG file with author slug as name.
     */
    public static function localPicture(Author $author): Author
    {
        $disk = 'authors';
        $custom_authors_path = public_path("storage/raw/pictures-$disk/$author->slug.jpg");

        if (File::exists($custom_authors_path)) {
            $file_path = File::get($custom_authors_path);
            $author->addMediaFromString($file_path)
                ->setName($author->slug)
                ->setFileName($author->slug . '.' . config('bookshelves.cover_extension'))
                ->toMediaCollection($disk, $disk);
            $author->save();
        }

        return $author;
    }

    public static function picture(Author $author, string | null $pageId): Author
    {
        $pictureDefault = database_path('seeders/media/authors/no-picture.jpg');
        $url = "http://en.wikipedia.org/w/api.php?action=query&prop=info&pageids=$pageId&inprop=url&format=json&prop=info|extracts&inprop=url&prop=pageimages&pithumbsize=512";
        $picture = null;

        if (! $pageId) {
            $defaultPictureFile = File::get($pictureDefault);
            $author->addMediaFromString($defaultPictureFile)
                ->setName($author->slug)
                ->setFileName($author->slug . '.' . config('bookshelves.cover_extension'))
                ->toMediaCollection('authors', 'authors');
        }

        $disk = 'authors';
        $custom_authors_path = public_path("storage/raw/pictures-$disk/$author->slug.jpg");
        if (File::exists($custom_authors_path)) {
            self::localPicture($author);
        } else {
            try {
                $response = Http::get($url);
                $response = $response->json();
                $picture = $response['query']['pages'];
                $picture = reset($picture);
                $picture = $picture['thumbnail']['source'];
            } catch (\Throwable $th) {
            }
            if (! is_string($picture)) {
                $defaultPictureFile = File::get($pictureDefault);
                $author->addMediaFromString($defaultPictureFile)
                    ->setName($author->slug)
                    ->setFileName($author->slug . '.' . config('bookshelves.cover_extension'))
                    ->toMediaCollection('authors', 'authors');
            } else {
                $author->addMediaFromUrl($picture)
                    ->setName($author->slug)
                    ->setFileName($author->slug . '.' . config('bookshelves.cover_extension'))
                    ->toMediaCollection('authors', 'authors');
            }
        }

        $image = $author->getFirstMediaPath('authors');
        $color = MetadataExtractorTools::simple_color_thief($image);
        $media = $author->getFirstMedia('authors');
        $media->setCustomProperty('color', $color);
        $media->save();

        return $author;
    }
}
