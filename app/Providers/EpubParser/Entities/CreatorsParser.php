<?php

namespace App\Providers\EpubParser\Entities;

/**
 * Manage Book Authors
 * 
 * @package App\Providers\EpubParser\Book
 */
class CreatorsParser
{
    public function __construct(
        public ?array $creators = [],
    ) {}

     /**
      * Generate author from XML dc:creator string.
      * 
      * @param iterable|string $creators 
      * @return CreatorsParser 
      */
    public static function run(iterable|string $creators): CreatorsParser
    {
        $creators_entities = [];

        if ($creators) {
            if (!is_array($creators)) {
                $creator_string = $creators;
                $creators = [];
                $creators[] = $creator_string;
            }
            foreach ($creators as $creator) {
                array_push($creators_entities, $creator);
            }
        }
        $creators_entities = array_unique($creators_entities);
        
        return new CreatorsParser(
            creators: $creators_entities
        );
    }
}
