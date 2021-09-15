<?php

namespace App\Providers\EbookParserEngine\Models;

class OpfIdentifier
{
    public function __construct(
        public ?string $name = null,
        public ?string $value = null,
    ) {
    }
    
    /**
     * Normalize identifier
     *
     * @param array $data [id, value]
     */
    public static function create(array $data): OpfIdentifier
    {
        $name = strtolower($data['id']);
        $value = $data['value'];

        if ('isbn' === $name) {
            $isbn_type = self::findIsbn($value);
            if (1 === $isbn_type) {
                $identifier = new OpfIdentifier(
                    name: 'isbn',
                    value: $value
                );
            }
            if (2 === $isbn_type) {
                $identifier = new OpfIdentifier(
                    name: 'isbn13',
                    value: $value
                );
            }
        } else {
            $identifier = new OpfIdentifier(
                name: $name,
                value: $value
            );
        }

        return $identifier;
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
