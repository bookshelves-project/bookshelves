<?php

namespace App\Utils;

use File;
use ZipArchive;
use App\Models\Book;
use Spatie\Image\Image;
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
        $json = json_encode($packageMetadata);

        $array = [];
        foreach ($packageMetadata as $k => $v) {
            $array[$k] = $v->__toString();
        }

        $book = Book::firstOrCreate(['title' => $array['title']]);

        $attributes = [
            'creator',
            'description',
            'language',
            'date',
            'contributor',
            'identifier',
            'subject',
            'publisher',
            'cover',
            'path',
        ];
        foreach ($array as $key => $value) {
            if ('title' !== $key && in_array($key, $attributes)) {
                $book->$key = $value;
            }
        }

        $book->slug = Str::slug($book->title, '-');

        // $cover = Image::load($cover)->save("$book->title.jpg");
        if ($cover_extension) {
            File::put(public_path("storage/covers/$book->slug.$cover_extension"), $cover);
        }

        $book->cover = "storage/covers/$book->slug.$cover_extension";
        $file = pathinfo($file_path)['basename'];

        $dirname = pathinfo($file_path)['dirname'];
        $string = 'app/public/books';
        $newFile = explode($string, $dirname);
        $pre = 'storage/books/';
        if ($newFile[1]) {
            $book->path = "$pre$newFile[1]/$file";
        } else {
            $book->path = "$pre$file";
        }
        $book->save();
    }
}
