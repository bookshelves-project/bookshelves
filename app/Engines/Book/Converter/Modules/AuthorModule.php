<?php

namespace App\Engines\Book\Converter\Modules;

use App\Models\Author;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Kiwilan\Ebook\Ebook;
use Kiwilan\Ebook\Tools\BookAuthor;

class AuthorModule
{
    protected function __construct(
        protected ?string $firstname,
        protected ?string $lastname,
        protected ?string $name,
        protected ?string $role,
    ) {
    }

    /**
     * Set Authors from Ebook.
     *
     * @return Collection<int, Author>
     */
    public static function toCollection(Ebook $ebook): Collection
    {
        $authors = $ebook->getAuthors();
        $items = collect([]);

        if (empty($authors)) {
            $author = AuthorModule::make(
                new BookAuthor(
                    name: 'Anonymous',
                    role: 'aut'
                )
            )->create();
            $items->push($author);

            return $items;
        }

        foreach ($authors as $author) {
            $current = AuthorModule::make($author);

            $detectHomonyms = config('bookshelves.authors.detect_homonyms');
            $existing = Author::whereFirstname($current->firstname)
                ->whereLastname($current->lastname)
                ->first();

            if ($detectHomonyms && ! $existing) {
                $existing = Author::whereFirstname($current->lastname)
                    ->whereLastname($current->firstname)
                    ->first();
            }

            if ($existing) {
                $author = $existing;
            } else {
                $author = $current->create();
            }

            if ($author !== null) {
                $items->push($author);
            }
        }

        return $items;
    }

    /**
     * Convert BookCreator to AuthorModule from config order.
     */
    public static function make(BookAuthor $author): ?self
    {
        $data = AuthorModule::convertName($author);

        return new self(
            firstname: $data['firstname'],
            lastname: $data['lastname'],
            name: $author->getName(),
            role: $data['role'],
        );
    }

    public function firstname(): ?string
    {
        return $this->firstname;
    }

    public function lastname(): ?string
    {
        return $this->lastname;
    }

    public function role(): ?string
    {
        return $this->role;
    }

    /**
     * Create Author if not exist.
     */
    private function create(): Author
    {
        return Author::query()
            ->firstOrCreate([
                'lastname' => $this->lastname,
                'firstname' => $this->firstname,
                'name' => $this->name,
                'slug' => Str::slug($this->name, '-'),
                'role' => $this->role,
            ]);
    }

    /**
     * @return array{firstname: string|null, lastname: string|null, role: string|null}
     */
    public static function convertName(BookAuthor $author): ?array
    {
        $a = [
            'firstname' => null,
            'lastname' => null,
            'role' => null,
        ];

        $pattern = '/(?<firstname>[A-Z][a-z.-]+(?: [A-Z][a-z.-]+)*)\s+(?<lastname>[A-Z][a-z.-]+(?: [A-Z][a-z.-]+)*)/';
        preg_match($pattern, $author->getName(), $matches);

        $a = [
            'firstname' => isset($matches['firstname']) ? $matches['firstname'] : null,
            'lastname' => isset($matches['lastname']) ? $matches['lastname'] : null,
            'role' => $author->getRole(),
        ];

        $isOrderNatural = config('bookshelves.authors.order_natural');
        if (! $isOrderNatural) {
            $a = [
                'firstname' => isset($matches['lastname']) ? $matches['lastname'] : null,
                'lastname' => isset($matches['firstname']) ? $matches['firstname'] : null,
                'role' => $author->getRole(),
            ];
        }

        return $a;
    }

    public static function makeAuthor(BookAuthor $author): Author
    {
        $data = AuthorModule::convertName($author);

        return new Author([
            'lastname' => $data['lastname'],
            'firstname' => $data['firstname'],
            'name' => $author->getName(),
            'slug' => Str::slug($author->getName(), '-'),
            'role' => $data['role'],
        ]);
    }

    /**
     * Convert data to Authors.
     *
     * @param  BookAuthor[]  $authors
     * @return Author[]
     */
    public static function toAuthors(array $authors): array
    {
        $items = [];

        foreach ($authors as $author) {
            $items[] = AuthorModule::makeAuthor($author);
        }

        return $items;
    }
}
