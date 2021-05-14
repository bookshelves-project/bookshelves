<?php

namespace App\Providers\Bookshelves;

use File;
use Http;
use App\Models\Author;
use App\Utils\BookshelvesTools;
use App\Providers\MetadataExtractor\MetadataExtractorTools;

class AuthorProvider
{
    /**
     * - Generate Author image from Wikipedia if found, managed by spatie/laravel-medialibrary, if not use default image 'database/seeders/media/authors/no-picture.jpg'
     * - Generate Author description from Wikipedia if found.
     *
     * @param Author $author
     *
     * @return Author
     */
    public static function descriptionAndPicture(Author $author): Author
    {
        $name = $author->name;
        $name = str_replace(' ', '%20', $name);
        $url = "https://en.wikipedia.org/w/api.php?action=query&list=search&srsearch=$name&format=json";
        $pictureDefault = database_path('seeders/media/authors/no-picture.jpg');
        $pageId = null;
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
        if ($pageId) {
            $url = "http://en.wikipedia.org/w/api.php?action=query&prop=info&pageids=$pageId&inprop=url&format=json&prop=info|extracts&inprop=url&prop=pageimages&pithumbsize=512";
            $picture = null;
            try {
                $response = Http::get($url);
                $response = $response->json();
                $picture = $response['query']['pages'];
                $picture = reset($picture);
                $picture = $picture['thumbnail']['source'];
            } catch (\Throwable $th) {
            }
            if (! is_string($picture)) {
                $picture = $pictureDefault;
                $defaultPictureFile = File::get($pictureDefault);
                $author->addMediaFromString($defaultPictureFile)
                            ->setName($author->slug)
                            ->setFileName($author->slug.'.'.config('bookshelves.cover_extension'))
                            ->toMediaCollection('authors', 'authors');
            } else {
                $author->addMediaFromUrl($picture)
                            ->setName($author->slug)
                            ->setFileName($author->slug.'.'.config('bookshelves.cover_extension'))
                            ->toMediaCollection('authors', 'authors');
            }

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
                $author->description = $desc;
                $author->description_link = $url;
                $author->save();
            }
        } else {
            $picture = $pictureDefault;
        }

        $author = $author->refresh();

        // Get color
        $image = $author->getFirstMediaPath('authors');
        $color = MetadataExtractorTools::simple_color_thief($image);
        $media = $author->getFirstMedia('authors');
        $media->setCustomProperty('color', $color);
        $media->save();

        return $author;
    }
}
