<?php

namespace App\Engines\Parser\Models;

class BookEntityIdentifier
{
    public function __construct(
        protected ?string $name = null,
        protected ?string $value = null,
    ) {
    }

    /**
     * Normalize identifier.
     *
     * @param  array  $data [id, value]
     */
    public static function create(array $data): ?BookEntityIdentifier
    {
        $name = strtolower($data['id']);
        $value = $data['value'];
        $identifier = null;

        if ('isbn' === $name) {
            $isbn_type = self::findIsbn($value);

            if (1 === $isbn_type) {
                $identifier = new BookEntityIdentifier(
                    name: 'isbn10',
                    value: $value
                );
            }

            if (2 === $isbn_type) {
                $identifier = new BookEntityIdentifier(
                    name: 'isbn13',
                    value: $value
                );
            }
        } else {
            $identifier = new BookEntityIdentifier(
                name: $name,
                value: $value
            );
        }

        return $identifier;
    }

    public static function findIsbn($str): int|false
    {
        $regex = '/\b(?:ISBN(?:: ?| ))?((?:97[89])?\d{9}[\dx])\b/i';

        if (preg_match($regex, str_replace('-', '', $str), $matches)) {
            return (10 === strlen($matches[1]))
                ? 1   // ISBN-10
                : 2;  // ISBN-13
        }

        return false; // No valid ISBN found
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
        ];
    }

    public function __toString(): string
    {
        return "{$this->name} {$this->value}";
    }
}
