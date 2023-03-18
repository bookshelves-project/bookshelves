<?php

namespace App\Engines\Parser\Modules;

use App\Engines\Parser\Models\BookEntityAuthor;
use App\Engines\Parser\Modules\Interface\ParserModule;
use App\Engines\Parser\Modules\Interface\ParserModuleInterface;
use App\Engines\Parser\Modules\Interface\XmlInterface;
use App\Engines\Parser\Parsers\ArchiveParser;
use App\Engines\ParserEngine;
use Illuminate\Support\Carbon;

class CbzModule extends ParserModule implements ParserModuleInterface, XmlInterface
{
    public function __construct(
        public ?string $type = null,
    ) {
    }

    public static function make(ParserEngine $parser, bool $debug = false): ParserModule
    {
        $self = ParserModule::create($parser, self::class, $debug);

        return ArchiveParser::make($self)->execute();
    }

    public function parse(array $metadata): ParserModule
    {
        $this->metadata = $metadata;
        $this->type = $this->metadata['@root'];

        $isSupported = match ($this->type) {
            'ComicInfo' => $this->comicInfo(),
            default => false,
        };

        if ($this->debug) {
            ParserEngine::printFile($this->metadata, "{$this->file->name()}-metadata.json");
        }

        if (! $isSupported) {
            $this->console->print("CbzModule {$this->type} not supported", 'red');
            $this->console->newLine();
        }

        return $this;
    }

    private function comicInfo(): static
    {
        if (! $this->metadata) {
            return $this;
        }

        $this->title = $this->extract('Title');
        $this->description = $this->extract('Summary');
        $this->serie = $this->extract('Series');
        $this->volume = $this->extract('Number');
        $this->publisher = $this->extract('Publisher');
        $this->language = $this->extract('LanguageISO');
        $this->authors = $this->setCreators('Writer');
        $this->date = $this->setDate();

        return $this;
    }

    private function extract(string $extractKey): ?string
    {
        if (array_key_exists($extractKey, $this->metadata)) {
            return $this->metadata[$extractKey];
        }

        return null;
    }

    private function setCreators(string $extractKey): array
    {
        if (array_key_exists($extractKey, $this->metadata)) {
            $items = [];
            $creators = explode(',', $this->metadata[$extractKey]);

            foreach ($creators as $creator) {
                $creator = new BookEntityAuthor(trim($creator), 'aut');
                $items[] = $creator;
            }

            return $items;
        }

        return [];
    }

    private function setDate(): ?string
    {
        $date = null;
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
            $date = $date->format('Y-m-d');
        }

        return $date;
    }
}
