<?php

namespace App\Providers\EpubParser\Entities;

class SubjectsParser
{
    public function __construct(
        public ?array $subjects = [],
    ) {}

    /**
     * Generate Tags from $tags
     * 
     * @param array|bool $tags 
     * @return SubjectsParser 
     */
    public static function run(array|bool $subjects): SubjectsParser
    {
        $subjects_entities = [];
        if (is_array($subjects)) {
            foreach ($subjects as $subject) {
                array_push($subjects_entities, $subject);
            }
        }
        $subjects_entities = array_unique($subjects_entities);
        
        return new SubjectsParser(subjects: $subjects_entities);
    }
}
