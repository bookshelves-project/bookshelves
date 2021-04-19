<?php

namespace App\Providers\MetadataExtractor\Parsers;

class IdentifiersParser
{
    public function __construct(
        public ?string $isbn = null,
        public ?string $isbn13 = null,
        public ?string $doi = null,
        public ?string $amazon = null,
        public ?string $google = null,
    ) {
    }

    /**
     * Generate ISBN from $identifiers.
     *
     * @param array|string $identifiers
     *
     * @return IdentifiersParser
     */
    public static function run(array $identifiers): IdentifiersParser
    {
        $isbn = null;
        $isbn13 = null;
        $doi = null;
        $amazon = null;
        $google = null;

        foreach ($identifiers as $key => $value) {
            $id = strtolower($value['id']);
            if ('isbn' === $id) {
                $isbn_type = self::findIsbn($value['value']);
                if (1 === $isbn_type) {
                    $isbn = $value['value'];
                }
                if (2 === $isbn_type) {
                    $isbn13 = $value['value'];
                }
            }
            match ($id) {
                'doi'    => $doi = $value['value'],
                'amazon' => $amazon = $value['value'],
                'google' => $google = $value['value'],
                default  => ''
            };
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