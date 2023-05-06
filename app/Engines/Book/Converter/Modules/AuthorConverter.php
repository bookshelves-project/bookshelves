<?php

namespace App\Engines\Book\Converter\Modules;

use App\Enums\AuthorRoleEnum;
use App\Enums\MediaDiskEnum;
use App\Models\Author;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Kiwilan\Ebook\Book\BookCreator;
use Kiwilan\Ebook\BookEntity;

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
     * Set Authors from BookEntity.
     *
     * @return Collection<int, Author>
     */
    public static function toCollection(BookEntity $book): Collection
    {
        $authors = $book->authors();
        $items = collect([]);

        if (empty($authors)) {
            $author = AuthorConverter::make(
                new BookCreator(
                    name: 'Anonymous Anonymous',
                    role: 'aut'
                )
            )->create();
            $items->push($author);

            return $items;
        }

        foreach ($authors as $author) {
            $isExists = false;
            $current = AuthorConverter::make($author);
            $detectHomonyms = config('bookshelves.authors.detect_homonyms');

            if (! $current) {
                continue;
            }

            // try to find homonyms in existing authors
            if ($detectHomonyms) {
                $existsAuthor = Author::whereFirstname($current->lastname)->first();

                if ($existsAuthor) {
                    $isExists = true;
                    $author = Author::whereLastname($existsAuthor->firstname)->first();
                }
            }

            // try to find in existing authors
            if (! $isExists) {
                $existsAuthor = Author::whereFirstname($current->firstname)
                    ->whereLastname($current->lastname)
                    ->first()
                ;

                if ($existsAuthor) {
                    $isExists = true;
                    $author = $existsAuthor;
                }
            }

            // create author if not exists
            if (! $isExists) {
                $current = AuthorConverter::make($author);
                $author = $current->create();
            }

            $items->push($author);
        }

        return $items;
    }

    /**
     * Convert BookCreator to AuthorConverter from config order.
     */
    public static function make(BookCreator $author): ?self
    {
        $lastname = null;
        $firstname = null;

        $authorName = explode(' ', $author->name());
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

        $role = $author->role();
        $firstname = trim($firstname);
        $lastname = trim($lastname);

        if (empty($firstname) && empty($lastname)) {
            return null;
        }

        return new self($firstname, $lastname, $role);
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
        $name = "{$this->lastname} {$this->firstname}";
        $name = trim($name);

        return Author::firstOrCreate([
            'lastname' => $this->lastname,
            'firstname' => $this->firstname,
            'name' => $name,
            'slug' => Str::slug($name, '-'),
            'role' => AuthorRoleEnum::tryFrom($this->role),
        ]);
    }
}
