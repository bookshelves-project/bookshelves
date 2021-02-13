<?php

namespace App\Providers\BookGenerator;

use File;
use Storage;
use App\Models\Tag;
use App\Models\Book;
use App\Models\Epub;
use App\Models\Cover;
use App\Models\Serie;
use App\Models\Author;
use Spatie\Image\Image;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Identifier;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Illuminate\Support\Facades\Http;
use App\Providers\EpubParser\EpubParser;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class BookGenerator
{
    public static function convertEpubParser(EpubParser $epubParser, bool $is_debug): Book
    {
        $bookIfExist = Book::whereSlug(Str::slug($epubParser->title, '-'))->first();
        $book = null;
        if (! $bookIfExist) {
            $book = Book::firstOrCreate([
                'title'        => $epubParser->title,
                'slug'         => Str::slug($epubParser->title, '-'),
                'title_sort'   => $epubParser->title_sort,
                'contributor'  => $epubParser->contributor,
                'description'  => $epubParser->description,
                'date'         => $epubParser->date,
                'rights'       => $epubParser->rights,
                'serie_number' => $epubParser->serie_number,
            ]);
            $authors = [];
            foreach ($epubParser->creators as $key => $creator) {
                $author_data = explode(' ', $creator);
                $lastname = $author_data[sizeof($author_data) - 1];
                array_pop($author_data);
                $firstname = implode(' ', $author_data);
                $author = Author::firstOrCreate([
                    'lastname'  => $lastname,
                    'firstname' => $firstname,
                    'name'      => "$firstname $lastname",
                    'slug'      => Str::slug("$lastname $firstname", '-'),
                ]);
                array_push($authors, $author);
            }
            $book->authors()->saveMany($authors);
            foreach ($epubParser->subjects as $key => $subject) {
                $tagIfExist = Tag::whereSlug(Str::slug($subject))->first();
                $tag = null;
                if (! $tagIfExist) {
                    $tag = Tag::firstOrCreate([
                        'name' => $subject,
                        'slug' => Str::slug($subject),
                    ]);
                }
                if (! $tag) {
                    $tag = $tagIfExist;
                }

                $book->tags()->save($tag);
            }
            $publisher = Publisher::firstOrCreate([
                'name' => $epubParser->publisher,
                'slug' => Str::slug($epubParser->publisher),
            ]);
            $book->publisher()->associate($publisher);
            if ($epubParser->serie) {
                $serieIfExist = Serie::whereSlug(Str::slug($epubParser->serie))->first();
                $serie = null;
                if (! $serieIfExist) {
                    $serie = Serie::firstOrCreate([
                        'title'      => $epubParser->serie,
                        'title_sort' => $epubParser->serie_sort,
                        'slug'       => Str::slug($epubParser->serie),
                    ]);
                } else {
                    $serie = $serieIfExist;
                }

                $book->serie()->associate($serie);
            }
            $language = Language::firstOrCreate([
                'slug' => $epubParser->language,
            ]);
            $language = self::generateLanguageFlag($language);
            $book->language()->associate($language->slug);
            $identifiers = Identifier::firstOrCreate([
                'isbn'   => $epubParser->identifiers->isbn,
                'isbn13' => $epubParser->identifiers->isbn13,
                'doi'    => $epubParser->identifiers->doi,
                'amazon' => $epubParser->identifiers->amazon,
                'google' => $epubParser->identifiers->google,
            ]);
            $book->identifier()->associate($identifiers);
            $book->save();
        }
        if (! $book) {
            $book = $bookIfExist;
        }

        return $book;
    }

    public static function generateNewEpub(Book $book, string $file_path)
    {
        $serie = $book->serie;
        $author = $book->authors[0];

        $ebook_extension = pathinfo($file_path)['extension'];
        if ($serie) {
            $new_file_name_serie = $serie->slug;
        }
        if ($author) {
            $new_file_name_author = $author->slug;
        }
        if ($serie && $author) {
            $serie_number = $book->serie_number;
            if (1 === strlen($serie_number)) {
                $serie_number = '0'.$serie_number;
            }
            $new_file_name = $new_file_name_author.'_'.$new_file_name_serie.'-'.$serie_number.'_'.$book->slug;
        } elseif ($author) {
            $new_file_name = $new_file_name_author.'_'.$book->slug;
        } else {
            $new_file_name = $book->slug;
        }

        if (pathinfo($file_path)['basename'] !== $new_file_name) {
            // if (! Storage::disk('public')->exists("books/$new_file_name")) {
            // Storage::disk('public')->copy($file_path, "books/$new_file_name");
            $epub_file = File::get(storage_path("app/public/$file_path"));
            $book->addMediaFromString($epub_file)
                ->setName($new_file_name)
                ->setFileName($new_file_name.".$ebook_extension")
                ->toMediaCollection('books_epubs', 'books_epubs');
            // }
        }

        // $epub = new Epub();
        // $epub_path = "storage/books/$new_file_name";
        // $epub->name = $new_file_name;
        // if (file_exists(public_path($epub_path))) {
        //     $epub->path = $epub_path;
        // } else {
        //     $epub->path = null;
        // }

        // $epub_file = Storage::disk('public')->size("books/$new_file_name");
        // $convert = human_filesize($epub_file);

        // $epub->size = $convert;
        // $epub->size_bytes = $epub_file;
        // $epub->save();

        // return $epub;
    }

    public static function generateAuthorPicture(Author $author, bool $is_debug): Author
    {
        $name = $author->name;
        $author_slug = $author->slug;
        $name = str_replace(' ', '%20', $name);
        $url = "https://en.wikipedia.org/w/api.php?action=query&origin=*&titles=$name&prop=pageimages&format=json&pithumbsize=512";
        $pictureAuthorDefault = database_path('seeders/media/authors/no-picture.jpg');
        if (! $is_debug) {
            try {
                $response = Http::get($url);
                $response = $response->json();
                $pictureAuthor = $response['query']['pages'];
                $pictureAuthor = reset($pictureAuthor);
                $pictureAuthor = $pictureAuthor['thumbnail']['source'];
            } catch (\Throwable $th) {
            }
            if (! is_string($pictureAuthor)) {
                $pictureAuthor = $pictureAuthorDefault;
                $defaultPictureFile = File::get($pictureAuthorDefault);
                $author->addMediaFromString($defaultPictureFile)
                    ->setName($author->slug)
                    ->setFileName($author->slug.'.jpg')
                    ->toMediaCollection('authors', 'authors');
            } else {
                $contents = file_get_contents($pictureAuthor);
                // $size = 'book_cover';
                // $dimensions = config("image.thumbnails.$size");
                $author->addMediaFromUrl($pictureAuthor)
                    ->setName($author->slug)
                    ->setFileName($author->slug.'.jpg')
                    ->toMediaCollection('authors', 'authors');
                // Storage::disk('public')->put("authors/$author_slug.jpg", $contents);

                // Image::load($image_path)
                //     ->fit(Manipulations::FIT_MAX, $dimensions['width'], $dimensions['height'])
                //     ->save();

                // $pictureAuthor = "storage/authors/$author_slug.jpg";
            }
            $optimizerChain = OptimizerChainFactory::create();
            $dimensions = config('image.thumbnails.book_cover');
            $image_path = $author->getMedia('authors')->first()->getPath();
            Image::load($image_path)
                ->fit(Manipulations::FIT_MAX, $dimensions['width'], $dimensions['height'])
                ->save($image_path);
            $optimizerChain->optimize($image_path);
        } else {
            $pictureAuthor = $pictureAuthorDefault;
        }

        // $author->picture = $pictureAuthor;
        $author->save();

        return $author;
    }

    public static function generateLanguageFlag(Language $language): Language
    {
        $languages_display = [
            'en' => 'English',
            'gb' => 'English',
            'fr' => 'French',
        ];
        $languages_id = [
            'en' => 'gb',
            'gb' => 'gb',
            'fr' => 'fr',
        ];
        $lang_id = $language->slug;
        $lang_flag = array_key_exists($lang_id, $languages_id) ? $languages_id[$lang_id] : $lang_id;

        $language->flag = "https://www.countryflags.io/$lang_flag/flat/32.png";
        $language->display = array_key_exists($lang_id, $languages_display) ? $languages_display[$lang_id] : $lang_id;
        $language->save();

        return $language;
    }

    public static function generateSerieCover(Serie $serie): Serie
    {
        // Add special cover if exist from `database/seeders/medias/series/`
        // Check if JPG file with series' slug name exist
        // To know slug name, check into database when serie was created
        $disk = 'series';
        $dimensions = config('image.thumbnails.book_cover');
        $custom_series_path = database_path("seeders/media/$disk/$serie->slug.jpg");
        $optimizerChain = OptimizerChainFactory::create();
        if (File::exists($custom_series_path)) {
            $file_path = File::get($custom_series_path);
            $serie->addMediaFromString($file_path)
                    ->setName($serie->slug)
                    ->setFileName($serie->slug.'.jpg')
                    ->toMediaCollection($disk, $disk);

            $image_path = $serie->getMedia($disk)->first()->getPath();
            Image::load($image_path)
                ->fit(Manipulations::FIT_MAX, $dimensions['width'], $dimensions['height'])
                ->save($image_path);
            $optimizerChain->optimize($image_path);
        } else {
            $bookIfExist = Book::whereSerieNumber(1)->whereSerieId($serie->id)->first();
            if ($bookIfExist) {
                $book = $bookIfExist;
                $file_path = File::get($book->getMedia('books')->first()->getPath());
                $serie->addMediaFromString($file_path)
                    ->setName($serie->slug)
                    ->setFileName($serie->slug.'.jpg')
                    ->toMediaCollection($disk, $disk);

                $image_path = $serie->getMedia($disk)->first()->getPath();
                Image::load($image_path)
                    ->fit(Manipulations::FIT_MAX, $dimensions['width'], $dimensions['height'])
                    ->save($image_path);
                $optimizerChain->optimize($image_path);
            }
        }

        return $serie;
    }

    public static function extractCoverAndGenerate(array $metadata, bool $isDebug = false)
    {
        $book = $metadata['book'];
        $cover_extension = $metadata['cover_extension'];
        $cover = $metadata['cover'];

        // Cover extract raw file
        // $cover_filename_without_extension = md5("$book->slug-$book->author");
        $cover_filename_without_extension = strtolower($book->slug.'-'.$book->authors[0]->slug);
        $cover_file = $cover_filename_without_extension.'.'.$cover_extension;
        if ($cover_extension) {
            Storage::disk('public')->put("covers-raw/$cover_file", $cover);
        }

        if ($cover_extension) {
            $size = 'book_cover';
            $dimensions = config('image.thumbnails.book_cover');
            $dimensions_thumbnail = config('image.thumbnails.book_thumbnail');
            $path = public_path("storage/covers-raw/$cover_file");
            $optimizerChain = OptimizerChainFactory::create();

            $disk = 'books';
            try {
                $file_path = File::get($path);
                $book->addMediaFromString($file_path)
                    ->setName($book->slug)
                    ->setFileName($book->slug.'.jpg')
                    ->toMediaCollection($disk, $disk);

                $image_path = $book->getMedia($disk)->first()->getPath();
                Image::load($image_path)
                    ->fit(Manipulations::FIT_MAX, $dimensions['width'], $dimensions['height'])
                    ->save($image_path);
                $optimizerChain->optimize($image_path);
                // copy of original cover in WEBP
                // $new_extension = '.jpg';
                // $path_original = public_path('storage/covers/original/'.$cover_filename_without_extension.$new_extension);
                // Image::load($path)
                //     ->save($path_original);
                // $cover_file = $cover_filename_without_extension.$new_extension;

                // if (! $isDebug) {
                //     $optimizerChain->optimize($path_original);

                //     $path_thumbnail = public_path('storage/covers/thumbnail/'.$cover_filename_without_extension.$new_extension);

                //     $optimizerChain->optimize($path_original);

                //     $path_basic = public_path('storage/covers/basic/'.$cover_filename_without_extension.$new_extension);
                //     Image::load($path_original)
                //         ->fit(Manipulations::FIT_MAX, $dimensions['width'], $dimensions['height'])
                //         ->save($path_basic);
                //     $optimizerChain->optimize($path_basic);
                // }

                // $cover_model = Cover::firstOrCreate([
                //     'name'      => $cover_filename_without_extension,
                //     'extension' => $new_extension,
                // ]);

                // $book->cover()->associate($cover_model);
                // $book->save();
            } catch (\Throwable $th) {
                // self::generateError('covers');
            }
        }
    }
}
