<?php

namespace App\Engines\ParserEngine\Modules;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\Models\BookCreator;
use App\Engines\ParserEngine\Parsers\XmlInterface;
use App\Engines\ParserEngine\Parsers\XmlParser;
use App\Services\ConsoleService;

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
        $xml = new XmlParser($engine, CbzModule::class);
        $xml = $xml->openZip(true);

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
            foreach ($this->xml_data as $node_key => $node) {
                $this->getRaw($node_key, $node, 'Title', 'title');
                $this->getRaw($node_key, $node, 'Series', 'serie');
                $this->getRaw($node_key, $node, 'Number', 'volume');
                $this->getCreators($node_key, $node, 'Writer', 'creators');
                $this->getRaw($node_key, $node, 'Publisher', 'publisher');
                $this->getRaw($node_key, $node, 'LanguageISO', 'language');
            }
        }

        return $this;
    }

    private function getRaw(string $node_key, mixed $node, string $extract_key, string $attribute): static
    {
        if ($node_key === $extract_key) {
            $this->engine->{$attribute} = $node;
        }

        return $this;
    }

    private function getCreators(string $node_key, mixed $node, string $extracted_key, string $attribute): static
    {
        if ($node_key === $extracted_key) {
            $creators = explode(',', $node);
            foreach ($creators as $creator) {
                $creator = new BookCreator(trim($creator), 'aut');
                array_push($this->engine->{$attribute}, $creator);
            }
        }

        return $this;
    }
}
