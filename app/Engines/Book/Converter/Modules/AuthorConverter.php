<?php

namespace App\Engines\Book\Converter\Modules;

use App\Enums\AuthorRoleEnum;
use App\Enums\MediaDiskEnum;
use App\Models\Author;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Kiwilan\Ebook\Book\BookCreator;
use Kiwilan\Ebook\Ebook;
use Kiwilan\Ebook\Tools\BookAuthor;

class AuthorConverter
{
    public const DISK = MediaDiskEnum::cover;

    protected function __construct(
        protected ?string $firstname,
        protected ?string $lastname,
        protected ?string $role,
    ) {
    }

    /**
     * Set Authors from Ebook.
     *
     * @return Collection<int, Author>
     */
    public static function toCollection(Ebook $book): Collection
    {
        $authors = $book->getAuthors();
        $items = collect([]);

        if (empty($authors)) {
            $author = AuthorConverter::make(
                new BookAuthor(
                    name: 'Anonymous',
                    role: 'aut'
                )
            )->create();
            $items->push($author);

            return $items;
        }

        foreach ($authors as $author) {
            $current = AuthorConverter::make($author);

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
     * Convert BookCreator to AuthorConverter from config order.
     */
    public static function make(BookAuthor $author): ?self
    {
        $data = AuthorConverter::convertName($author);

        return new self(
            firstname: $data['firstname'],
            lastname: $data['lastname'],
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
        $name = AuthorConverter::toName($this->lastname, $this->firstname);

        return Author::query()
            ->firstOrCreate([
                'lastname' => $this->lastname,
                'firstname' => $this->firstname,
                'name' => $name,
                'slug' => Str::slug($name, '-'),
                'role' => AuthorRoleEnum::tryFrom($this->role),
            ]);
    }

    public static function toName(?string $lastname, ?string $firstname): ?string
    {
        $name = "{$lastname} {$firstname}";

        return trim($name);
    }

    public static function convertName(BookAuthor $author): ?array
    {
        $lastname = null;
        $firstname = null;

        $authorName = explode(' ', $author->getName());
        $isOrderNatural = config('bookshelves.authors.order_natural');

        if ($isOrderNatural) {
            $lastname = $authorName[count($authorName) - 1];
            array_pop($authorName);
            $firstname = implode(' ', $authorName);
        } else {
            $firstname = $authorName[count($authorName) - 1];
            array_pop($authorName);
            $lastname = implode(' ', $authorName);
        }

        $role = $author->getRole();
        $firstname = trim($firstname);
        $lastname = trim($lastname);

        if (empty($firstname) && empty($lastname)) {
            return null;
        }

        return [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'role' => $role,
        ];
    }

    public static function makeAuthor(BookAuthor $author): Author
    {
        $data = AuthorConverter::convertName($author);
        $name = AuthorConverter::toName($data['lastname'], $data['firstname']);

        return new Author([
            'lastname' => $data['lastname'],
            'firstname' => $data['firstname'],
            'name' => $name,
            'slug' => Str::slug($name, '-'),
            'role' => AuthorRoleEnum::tryFrom($data['role']),
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
            $items[] = AuthorConverter::makeAuthor($author);
        }

        return $items;
    }
}
