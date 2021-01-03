<?php

namespace App\Utils;

use File;
use Storage;
use ZipArchive;
use App\Models\Book;
use App\Models\Serie;
use App\Models\Author;
use Illuminate\Support\Str;

class EpubParser
{
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
        $cover_path = null;
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
                $cover_path = $stat['name'];
                $cover_extension = pathinfo($stat['name'])['extension'];
                // $zip->extractTo(, $stat['name']);
                // file_put_contents(public_path('storage'), $zip->getFromName($stat['name']));
                $cover = $zip->getFromName($stat['name']);
            }
        }

        $package = simplexml_load_string($xml_string);
        $packageMetadata = $package->metadata->children('dc', true);
        // $json = json_encode($packageMetadata);
        // dump($package->metadata);

        $array = [];
        foreach ($packageMetadata as $k => $v) {
            $array[$k] = $v->__toString();
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

        $author = array_key_exists('creator', $array) ? $array['creator'] : null;
        if ($author) {
            $author = Author::firstOrCreate([
                'name' => $author,
            ]);
            $author->slug = Str::slug($author->name, '-');
            $author->save();
        }

        $book = Book::firstOrCreate(['title' => $array['title']]);

        $book->slug = Str::slug($book->title, '-');
        $book->author_id = $author->id;
        $book->description = array_key_exists('description', $array) ? $array['description'] : null;
        $book->language = array_key_exists('language', $array) ? $array['language'] : null;
        $book->publish_date = array_key_exists('date', $array) ? $array['date'] : null;
        $book->isbn = array_key_exists('identifier', $array) ? $array['identifier'] : null;
        $book->publisher = array_key_exists('publisher', $array) ? $array['publisher'] : null;
        if ($serie) {
            $book->serie_id = $serie->id;
            $book->serie_number = (int) $serie_number;
        }

        if ($serie) {
            $cover_file = $serie->slug.'_'.$book->slug.'.'.$cover_extension;
        } else {
            $cover_file = $book->slug.'.'.$cover_extension;
        }
        if ($cover_extension) {
            File::put(public_path("storage/covers/$cover_file"), $cover);
            $book->cover_path = "storage/covers/$cover_file";
        }

        $file = pathinfo($file_path)['basename'];

        $dirname = pathinfo($file_path)['dirname'];
        $string = 'app/public/books';
        $newFile = explode($string, $dirname);
        $pre = 'storage/books';
        if ($newFile[1]) {
            $book->epub_path = "$pre$newFile[1]/$file";
        } else {
            $book->epub_path = "$pre/$file";
        }

        $book->save();

        return $book;
    }

    public static function renameEbook(Book $book, string $file)
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
            Storage::disk('public')->rename($file, "books/$new_file_name");
        }

        $epub_path = "storage/books/$new_file_name";
        if (file_exists(public_path($epub_path))) {
            $book->epub_path = $epub_path;
        } else {
            $book->epub_path = null;
        }
        $book->save();
    }
}
