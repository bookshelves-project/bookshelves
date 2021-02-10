<?php

namespace App\Providers\EpubParser\Entities;

class IdentifiersParser
{
    public function __construct(
        public ?string $isbn = null,
        public ?string $isbn13 = null,
        public ?string $doi = null,
        public ?string $amazon = null,
        public ?string $google = null,
    ) {}

    /**
     * Generate ISBN from $identifiers
     * 
     * @param array|string $identifiers 
     * @return IdentifiersParser 
     */
    public static function run(array|string $identifiers): IdentifiersParser
    {
        $isbn = null;
        $isbn13 = null;
        $doi = null;
        $amazon = null;
        $google = null;
        
        if (!is_array($identifiers)) {
            $identifier_string = $identifiers;
            $identifiers = [];
            $identifiers[] = $identifier_string;
        }
        $identifiers = array_unique($identifiers);
        foreach ($identifiers as $key => $value) {
            if (self::findIsbn($value) === 1) {
                $isbn = $value;
            } else if(self::findIsbn($value) === 2) {
                $isbn13 = $value;
            } else if($key === 'doi') {
                $doi = $value;
            } else if($key === 'amazon') {
                $amazon = $value;
            } else if($key === 'google') {
                $google = $value;
            }
        }

        return new IdentifiersParser(
            isbn: $isbn,
            isbn13: $isbn13,
            doi: $doi,
            amazon: $amazon,
            google: $google,
        );
    }

    public static function findIsbn($str)
    {
        $regex = '/\b(?:ISBN(?:: ?| ))?((?:97[89])?\d{9}[\dx])\b/i';

        if (preg_match($regex, str_replace('-', '', $str), $matches)) {
            return (10 === strlen($matches[1]))
                ? 1   // ISBN-10
                : 2;  // ISBN-13
        }
        return false; // No valid ISBN found
    }
}
