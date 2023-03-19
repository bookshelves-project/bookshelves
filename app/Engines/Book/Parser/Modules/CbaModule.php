<?php

namespace App\Engines\Book\Parser\Modules;

use App\Engines\Book\Parser\Models\BookEntityAuthor;
use App\Engines\Book\Parser\Modules\Interface\ParserModule;
use App\Engines\Book\Parser\Modules\Interface\ParserModuleInterface;
use App\Engines\Book\Parser\Parsers\ArchiveParser;
use App\Engines\Book\ParserEngine;
use Illuminate\Support\Carbon;

class CbaModule extends ParserModule implements ParserModuleInterface
{
    public function __construct(
        public ?string $type = null,
    ) {
    }

    public static function make(ParserEngine $parser, bool $debug = false): ParserModule
    {
        $self = ParserModule::create($parser, self::class, $debug);

        $type = match ($parser->file()->extension()) {
            'cb7' => '7z',
            'cba' => 'ace',
            'cbr' => 'rar',
            'cbt' => 'tar',
            'cbz' => 'zip',
            default => 'zip',
        };

        return ArchiveParser::make($self)
            ->setType($type)
            ->execute()
        ;
    }

    public function parse(array $metadata): ParserModule
    {
        $this->setCover();

        if (empty($metadata)) {
            return $this;
        }

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
        if (! array_key_exists($extractKey, $this->metadata)) {
            return [];
        }

        $items = [];
        $creators = explode(',', $this->metadata[$extractKey]);

        foreach ($creators as $creator) {
            $creator = new BookEntityAuthor(trim($creator), 'aut');
            $items[] = $creator;
        }

        return $items;
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

    private function setCover()
    {
        $this->setCoverIsExists();
        $this->setCoverIsFirst();
    }
}
