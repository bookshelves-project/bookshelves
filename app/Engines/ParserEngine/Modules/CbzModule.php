<?php

namespace App\Engines\ParserEngine\Modules;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\Models\BookCreator;
use App\Engines\ParserEngine\Parsers\XmlInterface;
use App\Engines\ParserEngine\Parsers\XmlParser;
use App\Services\ConsoleService;
use Illuminate\Support\Carbon;

class CbzModule implements XmlInterface
{
    public function __construct(
        public ?array $xml_data = null,
        public ?string $type = null,
        public ?ParserEngine $engine = null,
    ) {
    }

    public static function create(ParserEngine $engine): ParserEngine|false
    {
        $parser = new XmlParser($engine, CbzModule::class);
        $xml = $parser->openZip(true);

        return $xml->engine;
    }

    public static function parse(XmlParser $xml): ParserEngine
    {
        $module = new CbzModule();

        $module->xml_data = $xml->xml_data;
        $module->engine = $xml->engine;

        $module->type = $module->xml_data['@root'];

        $is_supported = match ($module->type) {
            'ComicInfo' => $module->comicInfo(),
            default => false,
        };

        if ($xml->engine->debug) {
            ParserEngine::printFile($module->xml_data, "{$xml->engine->file_name}-metadata.json");
        }
        if (! $is_supported) {
            ConsoleService::error("CbzModule {$module->type} not supported");
        }

        return $module->engine;
    }

    private function comicInfo(): static
    {
        if ($this->xml_data) {
            $this->getRaw('Title', 'title');
            $this->getRaw('Summary', 'description');
            $this->getRaw('Series', 'serie');
            $this->getRaw('Number', 'volume');
            $this->getRaw('Publisher', 'publisher');
            $this->getRaw('LanguageISO', 'language');
            $this->getCreators('Writer', 'creators');
            $this->getDate();
        }

        return $this;
    }

    private function getRaw(string $extract_key, string $attribute): static
    {
        if (array_key_exists($extract_key, $this->xml_data)) {
            $this->engine->{$attribute} = $this->xml_data[$extract_key];
        }

        return $this;
    }

    private function getCreators(string $extracted_key, string $attribute): static
    {
        if (array_key_exists($extracted_key, $this->xml_data)) {
            $creators = explode(',', $this->xml_data[$extracted_key]);
            foreach ($creators as $creator) {
                $creator = new BookCreator(trim($creator), 'aut');
                array_push($this->engine->{$attribute}, $creator);
            }
        }

        return $this;
    }

    private function getDate(): static
    {
        $year = null;
        $month = null;
        $day = null;
        if (array_key_exists('Year', $this->xml_data)) {
            $year = $this->xml_data['Year'];
        }
        if (array_key_exists('Month', $this->xml_data)) {
            $month = $this->xml_data['Month'];
        }
        if (array_key_exists('Day', $this->xml_data)) {
            $day = $this->xml_data['Day'];
        }

        if ($year || $month || $day) {
            $date = Carbon::createFromDate($year, $month, $day);
            $this->engine->date = $date->format('Y-m-d');
        }

        return $this;
    }
}
