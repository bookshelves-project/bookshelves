<?php

namespace App\Engines\ParserEngine\Modules;

use App\Engines\ParserEngine;
use App\Engines\ParserEngine\Models\BookCreator;
use App\Engines\ParserEngine\Modules\Interface\Module;
use App\Engines\ParserEngine\Modules\Interface\ModuleInterface;
use App\Engines\ParserEngine\Modules\Interface\XmlInterface;
use App\Engines\ParserEngine\Parsers\ArchiveParser;
use Illuminate\Support\Carbon;
use Kiwilan\Steward\Utils\Console;

class CbzModule extends Module implements ModuleInterface, XmlInterface
{
    public function __construct(
        public ?string $type = null,
    ) {
    }

    public static function make(ParserEngine $engine, ?bool $cbr = false): ParserEngine|false
    {
        $archive = new ArchiveParser($engine, new CbzModule());
        $archive->is_rar = $cbr;
        $archive->find_cover = true;

        return $archive->open();
    }

    public static function parse(ArchiveParser $parser_engine): ParserEngine
    {
        /** @var CbzModule */
        $module = $parser_engine->module;

        $module->metadata = $parser_engine->metadata;
        $module->engine = $parser_engine->engine;

        $module->type = $module->metadata['@root'];

        $is_supported = match ($module->type) {
            'ComicInfo' => $module->comicInfo(),
            default => false,
        };

        if ($parser_engine->engine->debug) {
            ParserEngine::printFile($module->metadata, "{$parser_engine->engine->file_name}-metadata.json");
        }
        if (! $is_supported) {
            $console = Console::make();
            $console->print("CbzModule {$module->type} not supported", 'red');
            $console->newLine();
        }

        return $parser_engine->engine;
    }

    private function comicInfo(): static
    {
        if ($this->metadata) {
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
        if (array_key_exists($extract_key, $this->metadata)) {
            $this->engine->{$attribute} = $this->metadata[$extract_key];
        }

        return $this;
    }

    private function getCreators(string $extracted_key, string $attribute): static
    {
        if (array_key_exists($extracted_key, $this->metadata)) {
            $creators = explode(',', $this->metadata[$extracted_key]);
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
        if (array_key_exists('Year', $this->metadata)) {
            $year = $this->metadata['Year'];
        }
        if (array_key_exists('Month', $this->metadata)) {
            $month = $this->metadata['Month'];
        }
        if (array_key_exists('Day', $this->metadata)) {
            $day = $this->metadata['Day'];
        }

        if ($year || $month || $day) {
            $date = Carbon::createFromDate($year, $month, $day);
            $this->engine->date = $date->format('Y-m-d');
        }

        return $this;
    }
}
