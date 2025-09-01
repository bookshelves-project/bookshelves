<?php

namespace App\Engines\Converter\Modules;

use App\Models\Author;
use Illuminate\Support\Str;
use Kiwilan\Ebook\Models\BookAuthor;

class AuthorModuleItem
{
    public function __construct(
        public ?string $firstname = null,
        public ?string $lastname = null,
        public ?string $name = null,
        public ?string $role = null,
    ) {}

    /**
     * Convert BookCreator to AuthorModule from config order.
     */
    public static function make(BookAuthor $author): ?self
    {
        $self = new self(
            name: $author->getName(),
            role: $author->getRole(),
        );
        $converted = $self->convertName($author);
        $self->firstname = $converted['firstname'];
        $self->lastname = $converted['lastname'];

        return $self;
    }

    public function toAuthor(): Author
    {
        return Author::withoutSyncingToSearch(function () {
            return Author::create([
                'name' => $this->name,
                'slug' => Str::slug($this->name, '-'),
                'role' => $this->role,
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
            ]);
        });
    }

    /**
     * @return array{firstname: string|null, lastname: string|null}
     */
    private function convertName(BookAuthor $author): array
    {
        $a = [
            'firstname' => null,
            'lastname' => null,
        ];

        $isOrderNatural = config('bookshelves.authors.order_natural');
        if ($isOrderNatural) {
            $exploded = explode(' ', $author->getName());
            $a['lastname'] = array_pop($exploded);
            $a['firstname'] = implode(' ', $exploded);
        } else {
            $exploded = explode(' ', $author->getName());
            $a['firstname'] = array_shift($exploded);
            $a['lastname'] = implode(' ', $exploded);
        }

        return $a;
    }
}
