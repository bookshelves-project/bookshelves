<?php

namespace App\Utils;

use File;
use Storage;
use Exception;
use ZipArchive;
use App\Models\Book;
use App\Models\Epub;
use App\Models\Cover;
use App\Models\Serie;
use Biblys\Isbn\Isbn;
use SimpleXMLElement;
use App\Models\Author;
use Spatie\Image\Image;
use App\Models\Language;
use App\Models\Publisher;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Spatie\Image\Manipulations;
use Illuminate\Support\Facades\Http;
use League\HTMLToMarkdown\HtmlConverter;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Database\Eloquent\InvalidCastException;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Symfony\Component\Process\Exception\LogicException;
use Symfony\Component\Process\Exception\RuntimeException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Symfony\Component\Process\Exception\ProcessSignaledException;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Symfony\Component\Process\Exception\InvalidArgumentException as ExceptionInvalidArgumentException;

class EpubParser
{
    /**
     * Get metadata from EPUB and create Book
     * with relationships.
     *
     * @param string $file_path
     *
     * @throws BindingResolutionException
     * @throws InvalidCastException
     * @throws JsonEncodingException
     *
     * @return mixed
     */
    public static function getMetadata(string $file_path)
    {
        $file_path = storage_path("app/public/$file_path");

        $zip = new ZipArchive();
        $zip->open($file_path);
        $xml_string = '';
        $cover = null;
        $cover = '';
        $cover_extension = '';
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $stat = $zip->statIndex($i);
            if (strpos($stat['name'], '.opf')) {
                $xml_string = $zip->getFromName($stat['name']);
            }
            if (preg_match('/cover/', $stat['name'])) {
                if (array_key_exists('extension', pathinfo($stat['name']))) {
                    $cover_extension = pathinfo($stat['name'])['extension'];
                    if (preg_match('/jpg|jpeg|PNG|WEBP/', $cover_extension)) {
                        $cover = $stat['name'];
                        $cover = $zip->getFromName($stat['name']);
                    }
                }
            }
        }

        $package = simplexml_load_string($xml_string);
        $packageMetadata = $package->metadata->children('dc', true);

        $array = [];
        $identifiers = [];
        foreach ($packageMetadata as $k => $v) {
            if ('identifier' === $k) {
                $identifiers[] = $v;
            }
            $array[$k] = $v->__toString();
        }

        // ISBN
        $isbn = null;
        foreach ($identifiers as $key => $value) {
            $identifier = $value->__toString();
            if (preg_match('#^978(.*)$#i', $identifier) && 13 === strlen($identifier)) {
                $isbn = $identifier;
            }
        }
        $isbn_raw = $isbn;
        $isbn = new Isbn($isbn_raw);
        $isbn13 = null;

        try {
            $isbn->validate();
            $isbn13 = $isbn->format('ISBN-13');
        } catch (Exception $e) {
            // echo "An error occured while parsing $isbn_raw: ".$e->getMessage();
        }

        // Generate series
        $seriesData = self::generateSeries($package);
        $serie = $seriesData['serie'];
        $serie_number = $seriesData['serie_number'];

        // Generate author
        $author_data = array_key_exists('creator', $array) ? $array['creator'] : null;
        $author = self::generateAuthor($author_data);

        $publisher_data = array_key_exists('publisher', $array) ? $array['publisher'] : null;
        $publisher = null;
        if ($publisher_data) {
            $publisher = Publisher::firstOrCreate([
                'name'  => $publisher_data,
            ]);
            $publisher->slug = Str::slug("$publisher->name", '-');
            $publisher->save();
        }

        $lang_data = array_key_exists('language', $array) ? $array['language'] : null;
        $lang_id = $lang_data;
        $lang_flag = null;
        switch ($lang_id) {
            case 'en':
                $lang_flag = 'gb';
                $lang_id = 'en';
                break;

            case 'gb':
                $lang_flag = 'gb';
                $lang_id = 'en';
                break;

            case 'fr':
                $lang_flag = 'fr';
                $lang_id = 'fr';
                break;

            default:
                $lang_flag = $lang_id;
                break;
        }
        if ($lang_id) {
            $language = Language::firstOrCreate([
                'slug'  => $lang_id,
                'flag'  => "https://www.countryflags.io/$lang_flag/flat/32.png",
            ]);
        }

        $book = Book::firstOrCreate(['title' => $array['title']]);

        $description_html = array_key_exists('description', $array) ? $array['description'] : null;
        $isUTF8 = mb_check_encoding($description_html, 'UTF-8');
        $description_html = iconv('UTF-8', 'UTF-8//IGNORE', $description_html);
        if ($isUTF8) {
            $description_html = preg_replace('#<a.*?>.*?</a>#i', '', $description_html);
            $converter = new HtmlConverter();
            $description = $converter->convert($description_html);
            $description = strip_tags($description, '<br>');
            $description = Str::markdown($description);
        }

        $book->slug = Str::slug($book->title, '-');
        $book->author_id = null !== $author ? $author->id : null;
        $book->description = $description;
        $book->publish_date = array_key_exists('date', $array) ? $array['date'] : null;
        $book->isbn = $isbn13;

        if ($publisher) {
            $book->publisher_id = $publisher->id;
        }

        if ($serie) {
            $book->serie_id = $serie->id;
            $book->serie_number = (int) $serie_number;
        }

        if ($language) {
            $book->language_slug = $language->slug;
        }

        $file = pathinfo($file_path)['basename'];

        $dirname = pathinfo($file_path)['dirname'];
        $string = 'app/public/books';
        $newFile = explode($string, $dirname);
        $pre = 'storage/books';

        $epub = new Epub();
        $epub->name = $file;
        if ($newFile[1]) {
            $epub->path = "$pre$newFile[1]/$file";
        } else {
            $epub->path = "$pre/$file";
        }

        // Cover extract raw file
        $cover_filename_without_extension = md5("$book->slug-$book->author");
        $cover_file = $cover_filename_without_extension.'.'.$cover_extension;
        if ($cover_extension) {
            Storage::disk('public')->put("covers-raw/$cover_file", $cover);
        }

        $book->epub()->save($epub);
        $epub->book()->save($book);

        $epub->save();
        $book->save();

        return [
            'book'                      => $book,
            'cover_extension'           => $cover_extension,
        ];
    }

    /**
     * Generate new EPUB from original with standard name.
     *
     * @param Book   $book
     * @param string $file
     *
     * @throws InvalidArgumentException
     * @throws FileExistsException
     * @throws FileNotFoundException
     * @throws BindingResolutionException
     *
     * @return string
     */
    public static function generateNewEpub(Book $book, string $file)
    {
        $serie = $book->serie;
        $author = $book->author;

        $ebook_extension = pathinfo($file)['extension'];
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
        $new_file_name .= ".$ebook_extension";
        if (pathinfo($file)['basename'] !== $new_file_name) {
            if (! Storage::disk('public')->exists("books/$new_file_name")) {
                Storage::disk('public')->copy($file, "books/$new_file_name");
            }
        }

        $epub = $book->epub;
        $epub_path = "storage/books/$new_file_name";
        $epub->name = $new_file_name;
        if (file_exists(public_path($epub_path))) {
            $epub->path = $epub_path;
        } else {
            $epub->path = null;
        }

        $epub_file = Storage::disk('public')->size("books/$new_file_name");
        $convert = human_filesize($epub_file);

        $epub->size = $convert;
        $epub->size_bytes = $epub_file;
        $epub->save();

        return $new_file_name;
    }

    public static function generateCovers(Book $book, string $cover_extension)
    {
        $cover_filename_without_extension = md5("$book->slug-$book->author");
        $cover_file = $cover_filename_without_extension.'.'.$cover_extension;
        if ($cover_extension) {
            $size = 'book_cover';
            $dimensions = config("image.thumbnails.$size");
            $dimensions_thumbnail = config('image.thumbnails.book_thumbnail');
            $path = public_path("storage/covers-raw/$cover_file");
            $optimizerChain = OptimizerChainFactory::create();

            try {
                // copy of original cover in WEBP
                $new_extension = '.jpg';
                $path_original = public_path('storage/covers-original/'.$cover_filename_without_extension.$new_extension);
                Image::load($path)
                    ->save($path_original);
                $cover_file = $cover_filename_without_extension.$new_extension;
                $optimizerChain->optimize($path_original);

                $path_thumbnail = public_path('storage/cache/'.$cover_filename_without_extension.$new_extension);
                Image::load($path_original)
                    ->fit(Manipulations::FIT_MAX, $dimensions_thumbnail['width'], $dimensions_thumbnail['height'])
                    ->save($path_thumbnail);
                $optimizerChain->optimize($path_original);

                $path_basic = public_path('storage/covers-basic/'.$cover_filename_without_extension.$new_extension);
                Image::load($path_original)
                    ->fit(Manipulations::FIT_MAX, $dimensions['width'], $dimensions['height'])
                    ->save($path_basic);
                $optimizerChain->optimize($path_basic);

                $cover_file = $cover_filename_without_extension.$new_extension;
                $cover_model = Cover::firstOrCreate(['name' => $cover_filename_without_extension]);

                $book->cover()->save($cover_model);
                $cover_model->book()->save($book);

                $cover_model->save();
                $book->save();
            } catch (\Throwable $th) {
                dump('error');
                dump($th->getMessage());
            }
        }
    }

    /**
     * Generate author from XML dc:creator string.
     *
     * @param string $author_data
     *
     * @throws BindingResolutionException
     * @throws InvalidArgumentException
     * @throws Exception
     * @throws LogicException
     * @throws ExceptionInvalidArgumentException
     * @throws RuntimeException
     * @throws ProcessTimedOutException
     * @throws ProcessSignaledException
     *
     * @return mixed
     */
    public static function generateAuthor(string $author_data)
    {
        $author = null;
        if ($author_data) {
            $author_data = explode(' ', $author_data);
            $lastname = $author_data[sizeof($author_data) - 1];
            array_pop($author_data);
            $firstname = implode(' ', $author_data);
            $isExist = Author::whereSlug(Str::slug("$lastname $firstname", '-'))->first();
            $pictureAuthor = null;
            $author = Author::firstOrCreate([
                'lastname'  => $lastname,
                'firstname' => $firstname,
                'name'      => "$firstname $lastname",
                'slug'      => Str::slug("$lastname $firstname", '-'),
            ]);
            if (null === $isExist) {
                $name = "$firstname $lastname";
                $name = str_replace(' ', '%20', $name);
                $url = "https://en.wikipedia.org/w/api.php?action=query&origin=*&titles=$name&prop=pageimages&format=json&pithumbsize=512";
                try {
                    $response = Http::get($url);
                    $response = $response->json();
                    $pictureAuthor = $response['query']['pages'];
                    $pictureAuthor = reset($pictureAuthor);
                    $pictureAuthor = $pictureAuthor['thumbnail']['source'];
                } catch (\Throwable $th) {
                }
                $name = Str::slug("$firstname $lastname");
                if (! is_string($pictureAuthor)) {
                    // File::copy(database_path('seeders/medias/author-no-picture.jpg'), public_path("storage/authors/$name.jpg"));
                    $pictureAuthor = 'storage/authors/no-picture.jpg';
                } else {
                    $contents = file_get_contents($pictureAuthor);
                    $size = 'book_cover';
                    $dimensions = config("image.thumbnails.$size");
                    Storage::disk('public')->put("authors/$name.jpg", $contents);
                    $optimizerChain = OptimizerChainFactory::create();
                    Image::load(public_path("storage/authors/$name.jpg"))
                        ->fit(Manipulations::FIT_MAX, $dimensions['width'], $dimensions['height'])
                        ->save();
                    $optimizerChain->optimize(public_path("storage/authors/$name.jpg"));
                    $pictureAuthor = "storage/authors/$name.jpg";
                }
                $author->picture = $pictureAuthor;
                $author->save();
            }
        }

        return $author;
    }

    /**
     * Generate series from SimpleXMLElement $package
     * with Calibre meta.
     *
     * @param SimpleXMLElement $package
     *
     * @throws BindingResolutionException
     * @throws LogicException
     * @throws ExceptionInvalidArgumentException
     * @throws RuntimeException
     * @throws ProcessTimedOutException
     * @throws ProcessSignaledException
     *
     * @return array
     */
    public static function generateSeries(SimpleXMLElement $package)
    {
        $serie = null;
        $serie_number = null;
        // Parse all tags 'meta' into 'package' => 'metadata'
        foreach ($package->metadata as $key => $value) {
            foreach ($value->meta as $a => $b) {
                // get serie
                if (preg_match('/calibre:series$/', $b->attributes()->__toString())) {
                    foreach ($b->attributes() as $k => $v) {
                        if (! preg_match('/series$/', $v->__toString())) {
                            $serie = $v->__toString();
                        }
                    }
                }
                // get serie number
                if (preg_match('/series_index$/', $b->attributes()->__toString())) {
                    foreach ($b->attributes() as $k => $v) {
                        if (! preg_match('/calibre:series_index$/', $v->__toString())) {
                            $serie_number = $v->__toString();
                        }
                    }
                }
            }
        }

        // if meta exist
        if ($serie) {
            // create serie if not exist
            $serie = Serie::firstOrCreate(['title' => $serie]);
            $serie->slug = Str::slug($serie->title, '-');
            $serie->save();

            // Add special cover if exist from `database/seeders/medias/series/`
            // Check if JPG file with series' slug name exist
            // To know slug name, check into database when serie was created
            if (File::exists(database_path("seeders/medias/series/$serie->slug.jpg"))) {
                $optimizerChain = OptimizerChainFactory::create();
                File::copy(database_path("seeders/medias/series/$serie->slug.jpg"), public_path("storage/series/$serie->slug.jpg"));
                $path_serie_cover = "storage/series/$serie->slug.jpg";
                $serie->cover = $path_serie_cover;
                $size = 'book_cover';
                $dimensions = config("image.thumbnails.$size");
                Image::load(public_path($path_serie_cover))
                    ->fit(Manipulations::FIT_MAX, $dimensions['width'], $dimensions['height'])
                    ->save();
                $optimizerChain->optimize(public_path($path_serie_cover));
                $serie->save();
            }
        }

        return [
            'serie'        => $serie,
            'serie_number' => $serie_number,
        ];
    }
}
