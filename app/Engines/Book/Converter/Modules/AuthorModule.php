<?php

namespace App\Engines\Book\Converter\Modules;

use App\Jobs\Author\AuthorJob;
use App\Models\Author;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Kiwilan\Ebook\Ebook;
use Kiwilan\Ebook\Models\BookAuthor;

class AuthorModule
{
    /**
     * Handle Authors from Ebook.
     *
     * @param  BookAuthor[]  $authors
     * @return Collection<int, Author>
     */
    public static function make(array $authors): Collection
    {
        $self = new self;

        // `BookAuthor` to `AuthorModuleItem`
        $items = array_filter($authors, fn (BookAuthor $author) => $author->getName() !== null);
        if (empty($items)) {
            $items[] = $self->createAnonymousAuthor();
        }

        /** @var Collection<int, Author> $authors */
        $authors = collect();

        // `AuthorModuleItem` to `Author`
        foreach ($items as $item) {
            $authors->push(AuthorModuleItem::make($item)->toAuthor());
        }

        $authorsSaved = collect();
        foreach ($authors as $author) {
            $exists = Author::query()
                ->where('name', $author->name)
                ->first();

            if ($exists) {
                $author = $exists;
            } else {
                $author->saveNoSearch();
                AuthorJob::dispatch($author);
            }

            $authorsSaved->push($author);
        }

        return $authorsSaved;
    }

    private function createAnonymousAuthor(): AuthorModuleItem
    {
        return new AuthorModuleItem(
            firstname: 'Anonymous',
            lastname: null,
            name: 'Anonymous',
            role: 'aut'
        );
    }
}

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
        return new Author([
            'name' => $this->name,
            'slug' => Str::slug($this->name, '-'),
            'role' => $this->role,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
        ]);
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
