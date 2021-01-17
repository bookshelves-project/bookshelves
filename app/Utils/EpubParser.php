<?php

namespace App\Utils;

use File;
use Storage;
use Exception;
use ZipArchive;
use App\Models\Book;
use App\Models\Epub;
use App\Models\Serie;
use Biblys\Isbn\Isbn;
use App\Models\Author;
use Spatie\Image\Image;
use App\Models\Language;
use App\Models\Publisher;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\Image\Exceptions\InvalidManipulation;

class EpubParser
{
    /**
     * @param $file_path
     *
     * @throws InvalidManipulation
     *
     * @return mixed
     */
    public static function getMetadata(string $file_path)
    {
        // $file_path = $epub = storage_path('app\public\books\American Gods - Neil Gaiman.epub');
        $file_path = storage_path("app/public/$file_path");
        // $zipper = new \Madnest\Madzipper\Madzipper();
        // $zipper = $zipper->make($epub);
        // dd($zipper->getFileContent($epub));

        $zip = new ZipArchive();
        $zip->open($file_path);
        $xml_string = '';
        $cover = null;
        $cover = '';
        $cover_extension = '';
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $stat = $zip->statIndex($i);
            // dump(basename($stat['name']).PHP_EOL);
            if (strpos($stat['name'], '.opf')) {
                // $xml_string = $zip->getStream('container.xml');
                // dump(basename($stat['name']));
                // dump($stat['name']);
                $xml_string = $zip->getFromName($stat['name']);
            }
            if (preg_match('/cover/', $stat['name'])) {
                // $xml_string = $zip->getStream('container.xml');
                // dump(basename($stat['name']));
                // dump($stat['name']);
                // $xml_string = $zip->getFromName($stat['name']);
                $cover = $stat['name'];
                $cover_extension = pathinfo($stat['name'])['extension'];
                // $zip->extractTo(, $stat['name']);
                // file_put_contents(public_path('storage'), $zip->getFromName($stat['name']));
                $cover = $zip->getFromName($stat['name']);
            }
        }

        $package = simplexml_load_string($xml_string);
        $packageMetadata = $package->metadata->children('dc', true);
        // $json = json_encode($packageMetadata);
        // dump($packageMetadata);

        $array = [];
        $identifiers = [];
        foreach ($packageMetadata as $k => $v) {
            if ('identifier' === $k) {
                $identifiers[] = $v;
            }
            $array[$k] = $v->__toString();
        }

        // ISBN
        $isbn_raw = $identifiers[0];
        $isbn = new Isbn($isbn_raw);
        $isbn13 = null;

        try {
            $isbn->validate();
            $isbn13 = $isbn->format('ISBN-13');
            // echo "ISBN-13: $isbn13";
        } catch (Exception $e) {
            // echo "An error occured while parsing $isbn_raw: ".$e->getMessage();
        }

        $serie = '';
        $serie_number = '';
        // Parse all tags 'meta' into 'package' => 'metadata'
        foreach ($package->metadata as $key => $value) {
            foreach ($value->meta as $a => $b) {
                // get serie
                if (preg_match('/series$/', $b->attributes()->__toString())) {
                    foreach ($b->attributes() as $k => $v) {
                        if (! preg_match('/series$/', $v->__toString())) {
                            $serie = $v->__toString();
                        }
                    }
                }
                // get serie number
                if (preg_match('/series_index$/', $b->attributes()->__toString())) {
                    foreach ($b->attributes() as $k => $v) {
                        if (! preg_match('/series_index$/', $v->__toString())) {
                            $serie_number = $v->__toString();
                        }
                    }
                }
            }
        }

        if ($serie) {
            $serie = Serie::firstOrCreate(['title' => $serie]);
            $serie->slug = Str::slug($serie->title, '-');
            $serie->save();
        }

        $author_data = array_key_exists('creator', $array) ? $array['creator'] : null;
        $author = null;
        if ($author_data) {
            $author_data = explode(' ', $author_data);
            $lastname = $author_data[sizeof($author_data) - 1];
            array_pop($author_data);
            $firstname = implode(' ', $author_data);
            $author = Author::firstOrCreate([
                'lastname'  => $lastname,
                'firstname' => $firstname,
            ]);
            $author->slug = Str::slug("$lastname $firstname", '-');
            $author->save();
        }

        $publisher_data = array_key_exists('publisher', $array) ? $array['publisher'] : null;
        $publisher = null;
        if ($publisher_data) {
            $publisher = Publisher::firstOrCreate([
                'name'  => $publisher_data,
            ]);
            $publisher->slug = Str::slug("$publisher->name", '-');
            $publisher->save();
        }

        $language_data = array_key_exists('language', $array) ? $array['language'] : null;
        $language = null;
        if ($language_data) {
            if ('en' === $language_data) {
                $language_data = 'gb';
            }
            $language = Language::firstOrCreate([
                'slug'  => $language_data,
                'flag'  => "https://www.countryflags.io/$language_data/flat/32.png",
            ]);
        }

        $book = Book::firstOrCreate(['title' => $array['title']]);

        $book->slug = Str::slug($book->title, '-');
        $book->author_id = null !== $author ? $author->id : null;
        $book->description = array_key_exists('description', $array) ? $array['description'] : null;
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

        $cover_filename_without_extension = md5("$book->slug-$book->author");
        $cover_file = $cover_filename_without_extension.'.'.$cover_extension;
        if ($cover_extension) {
            $size = 'book_cover';
            $dimensions = config("image.thumbnails.$size");
            $path = public_path("storage/covers-original/$cover_file");
            $book->cover = "storage/covers/$cover_file";
            File::put(public_path("storage/covers-original/$cover_file"), $cover);
            try {
                Image::load($path)
                    ->fit(Manipulations::FIT_CROP, $dimensions['width'], $dimensions['height'])
                    ->save(public_path('storage/covers/'.$cover_filename_without_extension.'.webp'));
                $cover_file = $cover_filename_without_extension.'.webp';
                $book->cover = "storage/covers/$cover_file";
            } catch (\Throwable $th) {
                dump('error');
                dump($th->getMessage());
            }
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
        // $epub->book()->save($book);

        $book->epub()->save($epub);
        $epub->book()->save($book);
        $epub->save();
        $book->save();

        return $book;
    }

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
            $new_file_name = $new_file_name_author.'_'.$new_file_name_serie.'-'.$book->serie_number.'_'.$book->slug;
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
        $convert = self::human_filesize($epub_file);

        $epub->size = $convert;
        $epub->save();
    }

    public static function human_filesize($bytes, $decimals = 2)
    {
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)).@$sz[$factor];
    }
}
