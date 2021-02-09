<?php

namespace App\Utils;

use File;
use Storage;
use ZipArchive;
use App\Models\Book;
use App\Models\Epub;
use App\Models\Cover;
use App\Models\Serie;
use SimpleXMLElement;
use App\Models\Author;
use Spatie\Image\Image;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Tag;
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
    public static $original_filename;

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
    public static function getMetadata(string $file_path, bool $isDebug = false)
    {
        static::$original_filename = pathinfo($file_path)['filename'];

        try {
            $xml_parsed = self::parseXmlFile($file_path);
            $metadata = $xml_parsed['metadata'];
            $coverFile = $xml_parsed['coverFile'];
        } catch (\Throwable $th) {
            // self::generateError('XML file');

            return static::$original_filename;
        }

        // clean doublons tags, authors
        
        // parse metadata
        $title = $metadata['title'];
        $authors = $metadata['creator'];
        $contributor = $metadata['contributor'];
        $description = $metadata['description'];
        $date = $metadata['date'];
        $identifiers = $metadata['identifier'];
        $publisher = $metadata['publisher'];
        $tags = $metadata['subject'];
        $language = $metadata['language'];
        $rights = $metadata['rights'];
        $serie = $metadata['serie'];
        $serie_number = $metadata['serie_number'];
        $cover_extension = $metadata['cover_extension'];

        $identifiersFormated = self::generateIdentifiers($identifiers);
        $isbn13 = $identifiersFormated['isbn13'];

        $seriesData = self::generateSeries($serie, $serie_number);
        $serie = $seriesData['serie'];
        $serie_number = $seriesData['serie_number'];

        $tags = self::generateTags($tags);

        $authors = self::generateAuthors($authors, $isDebug);

        $publisher = self::generatePublisher($publisher);

        $language = self::generateLanguage($language);

        $epub = self::generateEpub($file_path);

        $book = self::generateBook(
            title: $title,
            description: $description,
            date: $date
        );

        $book->epub()->save($epub);
        $book->authors()->saveMany($authors);
        $book->tags()->saveMany($tags);
        if ($publisher) {
            $book->publisher()->associate($publisher);
        }
        $book->serie()->associate($serie);
        $book->serie_number = (int) $serie_number;
        $book->language()->associate($language);
        $book->isbn = $isbn13;
        $book->save();

        $epub->book()->save($book);
        $epub->save();

        return [
            'book'                      => $book,
            'cover'                     => [
                'file'      => $coverFile,
                'extension' => $cover_extension,
            ],
        ];
    }

    public static function generateError(string $type)
    {
        $error = "Error about $type: ".self::$original_filename;
        echo "\n";
        echo $error;
        echo "\n";
    }
    
    public static function generateTags(array|bool $tags)
    {
        $tags_entities = [];
        if (is_array($tags)) {
            foreach ($tags as $key => $tag) {
                $tag_entity = null;
                $tag_name = $tag;
                $tag_slug = Str::slug($tag_name, '-');
                $tagIfExist = Tag::whereSlug($tag_slug)->first();
                if (!$tagIfExist) {
                    $tag = Tag::firstOrCreate([
                        'name' => $tag_name,
                        'slug' => $tag_slug
                    ]);
                    $tag_entity = $tag;
                } else {
                    $tag_entity = $tagIfExist;
                }
                array_push($tags_entities, $tag_entity);
            }
        }
        return $tags_entities;
    }

    public static function generateEpub(string $file_path)
    {
        $file = pathinfo($file_path)['basename'];

        $dirname = pathinfo($file_path)['dirname'];
        $string = 'app/public/books';
        $newFile = explode($string, $dirname);
        $pre = 'storage/books';

        $epub = new Epub();
        $epub->name = $file;
        if (array_key_exists(1, $newFile)) {
            $epub->path = "$pre$newFile[1]/$file";
        } else {
            $epub->path = "$pre/$file";
        }
        $epub->save();

        return $epub;
    }

    public static function generateLanguage(string $language)
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
        $lang_id = $language;
        $lang_flag = array_key_exists($lang_id, $languages_id) ? $languages_id[$lang_id] : $lang_id;
        if ($lang_id) {
            $language = Language::firstOrCreate([
                'slug'    => $lang_id,
                'flag'    => "https://www.countryflags.io/$lang_flag/flat/32.png",
                'display' => array_key_exists($lang_id, $languages_display) ? $languages_display[$lang_id] : $lang_id,
            ]);
        }

        return $language;
    }

    public static function generateBook(?string $title, ?string $description, ?string $date)
    {
        $book_title = $title;
        $book_slug = Str::slug($book_title, '-');
        $bookIfExist = Book::whereSlug($book_slug)->first();
        if (! $bookIfExist) {
            $book = Book::firstOrCreate([
                'title' => $book_title,
                'slug'  => $book_slug,
            ]);
        } else {
            $book = $bookIfExist;
        }

        $title_sort = self::getSortString($book->title);
        $book->title_sort = $title_sort;

        $description_html = $description;
        $isUTF8 = mb_check_encoding($description_html, 'UTF-8');
        $description_html = iconv('UTF-8', 'UTF-8//IGNORE', $description_html);
        if ($isUTF8) {
            $description_html = preg_replace('#<a.*?>.*?</a>#i', '', $description_html);
            $converter = new HtmlConverter();
            try {
                $description = $converter->convert($description_html);
                $description = strip_tags($description, '<br>');
                $description = Str::markdown($description);
            } catch (\Throwable $th) {
                self::generateError('book description');
            }
        }
        $book->description = $description;
        $book->publish_date = $date ? $date : null;
        $book->save();

        return $book;
    }

    public static function generatePublisher(string $publisher)
    {
        if ($publisher) {
            $publisher_title = $publisher;
            $publisher_slug = Str::slug($publisher_title, '-');
            $publisherIfExist = Publisher::whereSlug($publisher_slug)->first();
            if (! $publisherIfExist) {
                $publisher = Publisher::firstOrCreate([
                    'name'  => $publisher_title,
                    'slug'  => $publisher_slug,
                ]);
            } else {
                $publisher = $publisherIfExist;
            }
        }

        return $publisher;
    }

    public static function parseXmlFile(string $file_path)
    {
        $file_path = storage_path("app/public/$file_path");

        $zip = new ZipArchive();
        $zip->open($file_path);
        $xml_string = '';
        $coverFile = '';
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
                        $coverFile = $stat['name'];
                        $coverFile = $zip->getFromName($stat['name']);
                    }
                }
            }
        }

        $package = simplexml_load_string($xml_string);
        try {
            $packageMetadata = $package->metadata->children('dc', true);
        } catch (\Throwable $th) {
            // self::generateError('metadata');
        }

        $serie = null;
        $serie_number = null;
        try {
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
        } catch (\Throwable $th) {
            //throw $th;
        }

        $metadata_from_xml = [];
        try {
            foreach ($packageMetadata as $k => $v) {
                $metadata_from_xml[$k][] = $v->__toString();
            }
        } catch (\Throwable $th) {
            // self::generateError('XML file invalid');

            return static::$original_filename;
        }

        $metadata_from_raw = [
            'title'        => [],
            'creator'      => [],
            'contributor'  => [],
            'description'  => [],
            'date'         => [],
            'identifier'   => [],
            'publisher'    => [],
            'subject'      => [],
            'language'     => [],
            'rights'       => [],
            'serie'        => [],
            'serie_number' => [],
        ];

        foreach ($metadata_from_xml as $key => $value) {
            if (array_key_exists($key, $metadata_from_raw)) {
                for ($i = 0; $i < sizeof($value); $i++) {
                    $el = $value[$i];
                    array_push($metadata_from_raw[$key], $el);
                }
            }
        }

        $metadata = [];
        foreach ($metadata_from_raw as $key => $meta) {
            if (sizeof($meta) <= 1) {
                $metadata[$key] = reset($meta);
            } else {
                $metadata[$key] = $meta;
            }
        }
        $metadata['serie'] = $serie ? $serie : null;
        $metadata['serie_number'] = $serie_number ? $serie_number : null;
        // $metadata['cover'] = $coverFile ? $coverFile : null;
        $metadata['cover_extension'] = $cover_extension ? $cover_extension : null;

        return [
            'metadata'             => $metadata,
            'coverFile'            => $coverFile,
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
        $author = $book->authors[0];

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

    public static function generateCovers(Book $book, string $cover_extension, string $cover, bool $isDebug = false)
    {
        // Cover extract raw file
        // $cover_filename_without_extension = md5("$book->slug-$book->author");
        $cover_filename_without_extension = strtolower($book->slug.'-'.$book->authors[0]->slug);
        $cover_file = $cover_filename_without_extension.'.'.$cover_extension;
        if ($cover_extension) {
            Storage::disk('public')->put("covers/raw/$cover_file", $cover);
        }

        if ($cover_extension) {
            $size = 'book_cover';
            $dimensions = config("image.thumbnails.$size");
            $dimensions_thumbnail = config('image.thumbnails.book_thumbnail');
            $path = public_path("storage/covers/raw/$cover_file");
            $optimizerChain = OptimizerChainFactory::create();

            try {
                // copy of original cover in WEBP
                $new_extension = '.jpg';
                $path_original = public_path('storage/covers/original/'.$cover_filename_without_extension.$new_extension);
                Image::load($path)
                    ->save($path_original);
                $cover_file = $cover_filename_without_extension.$new_extension;

                if (! $isDebug) {
                    $optimizerChain->optimize($path_original);

                    $path_thumbnail = public_path('storage/covers/thumbnail/'.$cover_filename_without_extension.$new_extension);
                    Image::load($path_original)
                        ->fit(Manipulations::FIT_MAX, $dimensions_thumbnail['width'], $dimensions_thumbnail['height'])
                        ->save($path_thumbnail);
                    $optimizerChain->optimize($path_original);

                    $path_basic = public_path('storage/covers/basic/'.$cover_filename_without_extension.$new_extension);
                    Image::load($path_original)
                        ->fit(Manipulations::FIT_MAX, $dimensions['width'], $dimensions['height'])
                        ->save($path_basic);
                    $optimizerChain->optimize($path_basic);
                }

                $cover_model = Cover::firstOrCreate([
                    'name'      => $cover_filename_without_extension,
                    'extension' => $new_extension,
                ]);

                $book->cover()->save($cover_model);
                $cover_model->book()->save($book);

                $cover_model->save();
                $book->save();
            } catch (\Throwable $th) {
                self::generateError('covers');
            }
        }
    }

    /**
     * Generate author from XML dc:creator string.
     *
     * @param string $author_data
     *
     * @return mixed
     */
    public static function generateAuthors(array|string $authors, bool $debug = false)
    {
        $authors_entities = [];
        if ($authors) {
            if (!is_array($authors)) {
                $author_string = $authors;
                $authors = [];
                $authors[] = $author_string;
            }
            foreach ($authors as $key => $author) {
                $author_entity = null;
                // Get firstname and lastname
                $author_data = explode(' ', $author);
                $lastname = $author_data[sizeof($author_data) - 1];
                array_pop($author_data);
                $firstname = implode(' ', $author_data);
                $author_slug = Str::slug("$lastname $firstname", '-');
                $authorIfExist = Author::whereSlug($author_slug)->first();
                $pictureAuthor = null;
    
                if (! $authorIfExist) {
                    $author = Author::firstOrCreate([
                        'lastname'  => $lastname,
                        'firstname' => $firstname,
                        'name'      => "$firstname $lastname",
                        'slug'      => $author_slug,
                    ]);
                    $name = "$firstname $lastname";
                    $name = str_replace(' ', '%20', $name);
                    $url = "https://en.wikipedia.org/w/api.php?action=query&origin=*&titles=$name&prop=pageimages&format=json&pithumbsize=512";
                    $pictureAuthorDefault = 'storage/authors/no-picture.jpg';
                    if (! $debug) {
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
                        } else {
                            $contents = file_get_contents($pictureAuthor);
                            $size = 'book_cover';
                            $dimensions = config("image.thumbnails.$size");
                            Storage::disk('public')->put("authors/$author_slug.jpg", $contents);
                            $optimizerChain = OptimizerChainFactory::create();
                            Image::load(public_path("storage/authors/$author_slug.jpg"))
                                ->fit(Manipulations::FIT_MAX, $dimensions['width'], $dimensions['height'])
                                ->save();
                            $optimizerChain->optimize(public_path("storage/authors/$author_slug.jpg"));
                            $pictureAuthor = "storage/authors/$author_slug.jpg";
                        }
                    } else {
                        $pictureAuthor = $pictureAuthorDefault;
                    }
    
                    $author->picture = $pictureAuthor;
                    $author->save();
                    $author_entity = $author;
                } else {
                    $author_entity = $authorIfExist;
                }
                array_push($authors_entities, $author_entity);
            }
        }

        return $authors_entities;
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
    public static function generateSeries(?string $serie, ?string $serie_number)
    {
        if ($serie) {
            $serie_title = $serie;
            $serie_slug = Str::slug($serie_title, '-');
            $serieIfExist = Serie::whereSlug($serie_slug)->first();
            // create serie if not exist
            if (! $serieIfExist) {
                $serie = Serie::firstOrCreate([
                    'title' => $serie_title,
                    'slug'  => $serie_slug,
                ]);
                $title_sort = self::getSortString($serie->title);
                $serie->title_sort = $title_sort;
                $serie->save();
            } else {
                $serie = $serieIfExist;
            }

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

    public static function generateIdentifiers(array|string $identifiers)
    {
        // ISBN
        $isbn = null;
        
        if (!is_array($identifiers)) {
            $identifier_string = $identifiers;
            $identifiers = [];
            $identifiers[] = $identifier_string;
        }
        foreach ($identifiers as $key => $value) {
            if (preg_match('#^978(.*)$#i', $value) && 13 === strlen($value)) {
                $isbn = $value;
            }
        }
        
        $isbn13 = $isbn;

        // try {
        //     $isbn_raw = $isbn;
        //     $isbn = new Isbn($isbn_raw);
        //     $isbn->validate();
        //     $isbn13 = $isbn->format('ISBN-13');
        // } catch (Exception $e) {
        //     // echo "An error occured while parsing $isbn_raw: ".$e->getMessage();
        //     // self::generateError('isbn');
        // }

        return [
            'isbn13'       => $isbn13,
        ];
    }

    public static function getSortString(string $title)
    {
        $title_sort = $title;
        $articles = [
            'the ',
            'les ',
            "l'",
            'le ',
            'la ',
            // 'a ',
            "d'",
            'une ',
        ];
        foreach ($articles as $key => $value) {
            $title_sort = preg_replace('/^'.preg_quote($value, '/').'/i', '', $title_sort);
        }
        // $title_sort = str_replace($articles, '', $title_sort);
        $title_sort = stripAccents($title_sort);

        return utf8_encode($title_sort);
    }
}
