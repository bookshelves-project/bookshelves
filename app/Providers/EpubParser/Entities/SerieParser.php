<?php

namespace App\Providers\EpubParser\Entities;

use File;
use App\Models\Serie;
use Spatie\Image\Image;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use App\Providers\EpubParser\EpubParser;
use App\Providers\EpubParser\EpubParserTools;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class SerieParser
{
    public function __construct(
        public ?string $title = null,
        public ?string $title_sort = null,
        public ?int $number = 0,
    ) {}

    /**
     * Generate series from SimpleXMLElement $package
     * with Calibre meta.
     *
     * @param SimpleXMLElement $package
     *
     * @return SerieParser
     */
    public static function run(?string $serie, ?string $serie_number): SerieParser
    {
        $title = null;
        $title_sort = null;
        
        if ($serie) {
            $title = $serie;
            $title_sort = EpubParserTools::getSortString($title);
        } else {
            $serie_number = 0;
        }

        return new SerieParser(
            title: $title,
            title_sort: $title_sort,
            number: intval($serie_number)
        );
    }
}
