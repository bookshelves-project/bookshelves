<?php

namespace App\Engines\Book\Converter\Modules;

use App\Engines\Book\Parser\Models\BookEntity;
use App\Engines\Book\Parser\Models\BookEntityAuthor;
use App\Enums\AuthorRoleEnum;
use App\Enums\MediaDiskEnum;
use App\Models\Author;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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
    public static function toCollection(BookEntity $entity): Collection
    {
        $authors = collect([]);

        if (empty($entity->authors())) {
            $author = AuthorConverter::make(new BookEntityAuthor(
                name: 'Anonymous Anonymous',
                role: 'aut'
            ))->create();
            $authors->push($author);

            return $authors;
        }

        foreach ($entity->authors() as $entityAuthor) {
            $currentAuthor = AuthorConverter::make($entityAuthor);
            $author = null;

            if ($currentAuthor && config('bookshelves.authors.detect_homonyms')) {
                $lastname = Author::whereFirstname($currentAuthor->lastname)->first();

                if ($lastname) {
                    $author = Author::whereLastname($currentAuthor->firstname)->first();
                }
            }

            if (null === $author) {
                $currentAuthor = AuthorConverter::make($entityAuthor);
                $author = $currentAuthor->create();
            }

            $authors->push($author);
        }

        return $authors;
    }

    /**
     * Convert BookEntityAuthor to AuthorConverter from config order.
     */
    public static function make(BookEntityAuthor $author): ?self
    {
        $lastname = null;
        $firstname = null;

        $author_name = explode(' ', $author->name());

        if (config('bookshelves.authors.order_natural')) {
            $lastname = $author_name[count($author_name) - 1];
            array_pop($author_name);
            $firstname = implode(' ', $author_name);
        } else {
            $firstname = $author_name[count($author_name) - 1];
            array_pop($author_name);
            $lastname = implode(' ', $author_name);
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
