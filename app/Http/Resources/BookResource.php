<?php

namespace App\Http\Resources;

use League\HTMLToMarkdown\HtmlConverter;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $serie = null;
        $author = null;
        $epub = null;
        $publisher = null;
        $language = null;
        if ($this->serie) {
            $serie = new SerieResource($this->serie);
        }
        if ($this->author) {
            $author = $this->author;
        }
        if ($this->epub) {
            $epub = new EpubResource($this->epub);
        }
        if ($this->publisher) {
            $publisher = new PublisherResource($this->publisher);
        }
        if ($this->language) {
            $language = $this->language;
        }
        $cover_basic = null;
        $cover_thumbnail = null;
        $cover_original = null;
        if ($this->cover) {
            $cover = $this->cover;

            $cover_basic = $cover->basic;
            $cover_thumbnail = $cover->thumbnail;
            $cover_original = $cover->original;
        }
        $summary = null;
        if ($this->description) {
            $converter = new HtmlConverter();

            $html = $this->description;
            $summary = $converter->convert($html);
            $summary = json_encode($summary, JSON_UNESCAPED_UNICODE);

            if (strlen($summary) > 165) {
                $summary = substr($summary, 0, 165).'...';
            }
        }

        return [
            'title'                 => $this->title,
            'slug'                  => $this->slug,
            'author'                => $author ? [
                'name'        => $author->name,
                'slug'        => $author->slug,
                'firstname'   => $author->firstname,
                'lastname'    => $author->lastname,
                'show'        => config('app.url')."/api/authors/$author->slug",
            ] : null,
            'summary'               => $summary,
            'description'           => $this->description,
            'language'              => [
                'slug' => $language->slug,
                'flag' => $language->flag,
            ],
            'publishDate'           => $this->publish_date,
            'isbn'                  => $this->isbn,
            'publisher'             => $publisher,
            'cover'                 => [
                'basic'     => $cover_basic,
                'thumbnail' => $cover_thumbnail,
                'original'  => $cover_original,
            ],
            'epub'                  => $epub ? $epub : null,
            'serie'                 => $serie ? [
                'number'  => $this->serie_number ? $this->serie_number : null,
                'title'   => $serie ? $serie->title : null,
                'slug'    => $serie ? $serie->slug : null,
                'show'    => config('app.url')."/api/series/$serie->slug",
            ] : null,
        ];
    }

    public static function convert_from_latin1_to_utf8_recursively($dat)
    {
        if (is_string($dat)) {
            return utf8_encode($dat);
        } elseif (is_array($dat)) {
            $ret = [];
            foreach ($dat as $i => $d) {
                $ret[$i] = self::convert_from_latin1_to_utf8_recursively($d);
            }

            return $ret;
        } elseif (is_object($dat)) {
            foreach ($dat as $i => $d) {
                $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);
            }

            return $dat;
        }

        return $dat;
    }
}
