<?php

namespace App\Http\Controllers\Webreader;

use ZipArchive;
use DOMDocument;
use App\Models\Book;
use App\Models\Author;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use League\HTMLToMarkdown\HtmlConverter;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use App\Providers\MetadataExtractor\Parsers\CreatorParser;
use App\Providers\MetadataExtractor\MetadataExtractorTools;

/**
 * @hideFromAPIDocumentation
 */
class WebreaderController extends Controller
{
    public function index()
    {
        $random_book = Book::inRandomOrder()->first();
        $route = route('webreader.cover', ['author' => $random_book->meta_author, 'book' => $random_book->slug]);

        return view('pages.webreader.index', compact('random_book', 'route'));
    }

    public function cover(string $author, string $book)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $book = Book::whereHas('authors', function ($query) use ($author) {
            return $query->where('author_id', '=', $author->id);
        })->whereSlug($book)->firstOrFail();
        
        $cover = $book->image_original;
        
        $title = $book->title;
        $title .= $book->serie ? ' ('.$book->serie->title.', vol. '.$book->volume.')' : '';
        $title .= ' by '.$book->authors_names;

        $open = route('webreader.page', ['author' => request()->author, 'book' => request()->book, 'page' => 1]);

        return view('pages.webreader.cover', compact('cover', 'book', 'open', 'title'));
    }

    public function read(string $author, string $book, string $page)
    {
        $author = Author::whereSlug($author)->firstOrFail();
        $book = Book::whereHas('authors', function ($query) use ($author) {
            return $query->where('author_id', '=', $author->id);
        })->whereSlug($book)->firstOrFail();

        $page = intval($page);

        $title = 'Page '.$page.' in ';
        $title .= $book->title;
        $title .= $book->serie ? ' ('.$book->serie->title.', vol. '.$book->volume.')' : null;
        $title .= ' by '.$book->authors_names;

        $epub_path = $book->getFirstMediaPath('epubs');
        $epub_file = $book->getFirstMedia('epubs');

        $disk = public_path('storage/cache/'.$book->slug);
        $is_exist = File::exists('storage/webreader/'.$epub_file->file_name);
        if (! $is_exist) {
            $metadata = self::parseXMLFile($epub_path, $disk, true);
        } elseif (sizeof(File::allFiles('storage/webreader/'.$epub_file->file_name)) <= 0) {
            $metadata = self::parseXMLFile($epub_path, $disk, true);
        }

        $webreader_files = 'storage/webreader/'.$epub_file->file_name.'/';
        $filePath = $webreader_files.$page.'.md';
        if (! File::exists($filePath)) {
            return redirect()->route('webreader.page', ['author' => request()->author, 'book' => request()->book, 'page' => 1]);
        }
        $file = File::get($filePath);
        $max_pages = sizeof(File::allFiles($webreader_files));

        $current_page_content = $file;
        $current_page_content = app(MarkdownRenderer::class)->toHtml($current_page_content);
        
        $next_page = request()->page + 1;
        if ($next_page > $max_pages) {
            $next_page = null;
        }

        $previous_page = request()->page - 1;
        if ($previous_page <= 0) {
            $previous_page = null;
        }

        $next = $next_page ? route('webreader.page', ['author' => request()->author, 'book' => request()->book, 'page' => $next_page]) : null;
        $prev = $previous_page ? route('webreader.page', ['author' => request()->author, 'book' => request()->book, 'page' => $previous_page]) : null;
        $last = route('webreader.page', ['author' => request()->author, 'book' => request()->book, 'page' => $max_pages]);
        
        return view('pages.webreader.page', compact('current_page_content', 'page', 'next', 'prev', 'last', 'title'));
    }

    public static function parseXMLFile(string $filepath, string $disk, bool $debug = false): array
    {
        // $filepath = storage_path("app/public/$filepath");
        $metadata = [];

        $zip = new ZipArchive();
        $zip->open($filepath);
        $xml_string = '';

        // extract .opf file
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $file = $zip->statIndex($i);
            if (strpos($file['name'], '.opf')) {
                $xml_string = $zip->getFromName($file['name']);
            }
        }

        // Transform XML to Array
        $metadata = self::convertXML(xml: $xml_string, filepath: $filepath, debug: $debug);

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $file = $zip->statIndex($i);
            $cover = $zip->getFromName($metadata['cover']['file']);
        }
        $metadata['cover']['file'] = $cover;

        $zip->close();

        return $metadata;
    }

    public static function convertXML(string $xml, string $filepath, bool $debug = false): array
    {
        $xml = MetadataExtractorTools::XMLtoArray($xml);
        $xml = $xml['PACKAGE'];
        $cover = null;
        $manifest = $xml['MANIFEST']['ITEM'];
        foreach ($manifest as $key => $value) {
            if ('cover' === $value['ID']) {
                $cover = $value;
            }
        }

        $xml['COVER'] = $cover;
        $title = pathinfo($filepath)['basename'];

        $manifest = [];
        try {
            $meta = $xml['MANIFEST'];

            $meta_manifest = $meta['ITEM'] ?? null;

            $zip = new ZipArchive();
            $zip->open($filepath);

            foreach ($meta_manifest as $key => $value) {
                $value['CONTENT'] = $zip->getFromName($value['HREF']);
                array_push($manifest, $value);
            }

            try {
                Storage::disk('public')->makeDirectory("/webreader/$title");
                $i = 0;
                foreach ($manifest as $key => $value) {
                    $d = new DOMDocument;
                    $mock = new DOMDocument;
                    libxml_use_internal_errors(true);
                    $d->loadHTML($value['CONTENT']);
                    libxml_clear_errors();
                    $body = $d->getElementsByTagName('body')->item(0);
                    foreach ($body->childNodes as $child) {
                        $mock->appendChild($mock->importNode($child, true));
                    }
                    $file = $mock->saveHTML();
                    $file = preg_replace("/<img[^>]+\>/i", '', $file);
                    $file = str_replace('&nbsp;', '', $file);

                    $converter = new HtmlConverter();
                    $markdown = $converter->convert($file);
                    $markdown = strip_tags($markdown);
                    $markdown = trim(str_replace('\n', '', (str_replace('\r', '', $markdown))));
                    $markdown = str_replace('* *', '', $markdown);
                    $markdown = str_replace('**', '', $markdown);

                    $is_not_empty = $markdown != '';

                    if ($value['MEDIA-TYPE'] === 'application/xhtml+xml' && $value['ID'] !== 'titlepage' && $is_not_empty) {
                        $i++;
                        Storage::disk('public')->put("/webreader/$title/$i.md", $markdown);
                    }
                }
            } catch (\Throwable $th) {
                // dump($th);
            }

            $zip->close();
        } catch (\Throwable $th) {
        }

        $metadata = [];
        try {
            $meta = $xml['METADATA'];
            $creators = $meta['DC:CREATOR'] ?? null;
            $creators_arr = [];
            if (count($creators) == count($creators, COUNT_RECURSIVE)) {
                array_push($creators_arr, new CreatorParser(name: $creators['content'], role: $creators['OPF:ROLE']));
            } else {
                foreach ($creators as $key => $value) {
                    array_push($creators_arr, new CreatorParser(name: $value['content'], role: $value['OPF:ROLE']));
                }
            }

            $contributors = $meta['DC:CONTRIBUTOR'] ?? null;
            $contributors_arr = [];
            foreach ($contributors as $key => $value) {
                // only one contributor
                if ('content' === $key) {
                    array_push($contributors_arr, $value);
                // More than one contributor
                } elseif (is_numeric($key)) {
                    array_push($contributors_arr, $value['content']);
                }
            }
            $contributors = implode(',', $contributors_arr);

            $identifiers = $meta['DC:IDENTIFIER'] ?? null;
            $identifiers_arr = [];
            foreach ($identifiers as $key => $value) {
                // More than one identifier
                if (is_numeric($key)) {
                    array_push($identifiers_arr, [
                        'id'    => $value['OPF:SCHEME'],
                        'value' => $value['content'],
                    ]);
                } else {
                    $identifiers_arr = [];
                }
            }
            // only one identifier
            if (! sizeof($identifiers_arr)) {
                $identifiers_arr[0]['id'] = $identifiers['OPF:SCHEME'];
                $identifiers_arr[0]['content'] = $identifiers['content'];
            }

            $subjects_arr = [];

            try {
                $subjects = (array) $meta['DC:SUBJECT'] ?? null;
                foreach ($subjects as $key => $value) {
                    array_push($subjects_arr, $value);
                }
            } catch (\Throwable $th) {
                //throw $th;
            }

            $serie = null;
            $volume = null;
            $meta_serie = $meta['META'] ?? null;
            foreach ($meta_serie as $key => $value) {
                if ('calibre:series' === $value['NAME']) {
                    $serie = $value['CONTENT'];
                }
                if ('calibre:series_index' === $value['NAME']) {
                    $volume = $value['CONTENT'];
                }
            }

            $cover = [
                'file'      => $cover['HREF'] ?? null,
                'extension' => pathinfo($cover['HREF'], PATHINFO_EXTENSION) ?? null,
            ];

            $metadata = [
                'title'       => $meta['DC:TITLE'] ?? null,
                'creators'    => $creators_arr,
                'contributor' => $contributors,
                'description' => $meta['DC:DESCRIPTION'] ?? null,
                'date'        => $meta['DC:DATE'] ?? null,
                'identifiers' => $identifiers_arr,
                'publisher'   => $meta['DC:PUBLISHER'] ?? null,
                'subjects'    => $subjects_arr,
                'language'    => $meta['DC:LANGUAGE'] ?? null,
                'rights'      => $meta['DC:RIGHTS'] ?? null,
                'serie'       => $serie,
                'volume'      => $volume,
                'cover'       => $cover,
                'manifest'    => $manifest,
                'file'        => $title
            ];
        } catch (\Throwable $th) {
            dump($th);
        }

        return $metadata;
    }
}
