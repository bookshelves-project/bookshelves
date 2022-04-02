<?php

namespace App\Docs\Strategies;

use App\Enums\BookFormatEnum;
use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
use App\Models\Page;
use App\Models\Post;
use App\Models\Publisher;
use App\Models\Serie;
use App\Models\TagExtend;
use App\Models\User;
use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Knuckles\Scribe\Extracting\ParamHelpers;
use Knuckles\Scribe\Extracting\Strategies\Strategy;

class BookshelvesParameter extends Strategy
{
    use ParamHelpers;

    public function __construct(
        public mixed $routeName,
        public ?array $urlParams = []
    ) {
    }

    public function __invoke(ExtractedEndpointData $endpointData, array $routeRules): ?array
    {
        $this->routeName = $endpointData->route->getName();

        $this->routes();

        return $this->urlParams;
    }

    private function routes()
    {
        $routes = [
            'authors.show' => 'author',
            'authors.show.books' => 'author',
            'authors.show.series' => 'author',
            'books.show' => 'book',
            'languages.show' => 'language',
            'publishers.show' => 'publisher',
            'publishers.show.books' => 'publisher',
            'series.show' => 'serie',
            'series.show.books' => 'serie',
            'series.current' => 'serieVolume',
            'posts.show' => 'post',
            'pages.show' => 'page',
            'entities.related' => 'book',
            'download.book' => 'downloadBook',
            'download.serie' => 'downloadSerie',
            'download.author' => 'downloadAuthor',
            'tags.show' => 'tag',
            'tags.show.books' => 'tag',
            'users.show' => 'user',
            'users.comments' => 'user',
            'users.favorites' => 'user',
        ];

        foreach ($routes as $name => $method) {
            if ("api.{$name}" === $this->routeName) {
                $this->urlParams = $this->{$method}();
            }
        }
    }

    private function author(): array
    {
        $author = Author::inRandomOrder()->first();

        return [
            ...$this->author_slug($author),
        ];
    }

    private function post(): array
    {
        $post = Post::published()->inRandomOrder()->first();

        return [
            ...$this->post_slug($post),
        ];
    }

    private function page(): array
    {
        $page = Page::published()->inRandomOrder()->first();

        return [
            ...$this->page_slug($page),
        ];
    }

    private function book(): array
    {
        $book = Book::inRandomOrder()->first();

        return [
            ...$this->author_slug($book->author),
            ...$this->book_slug($book),
        ];
    }

    private function serie(): array
    {
        $serie = Serie::inRandomOrder()->first();

        return [
            ...$this->author_slug($serie->author),
            ...$this->serie_slug($serie),
        ];
    }

    private function serieVolume(): array
    {
        $volume = [
            'volume' => [
                'description' => 'Current volume',
                'type' => 'int',
                'required' => true,
                'example' => 1,
            ],
        ];
        $serie = $this->serie();

        return array_merge($volume, $serie);
    }

    private function downloadBook(): array
    {
        $book = Book::inRandomOrder()->first();

        return [
            ...$this->author_slug($book->author),
            ...$this->book_slug($book),
            ...$this->format(),
        ];
    }

    private function downloadAuthor(): array
    {
        $author = Author::inRandomOrder()->first();

        return [
            ...$this->author_slug($author),
            ...$this->format(),
        ];
    }

    private function downloadSerie(): array
    {
        $serie = Serie::inRandomOrder()->first();

        return [
            ...$this->author_slug($serie->author),
            ...$this->serie_slug($serie),
            ...$this->format(),
        ];
    }

    private function tag(): array
    {
        /** @var TagExtend $tag */
        $tag = TagExtend::inRandomOrder()->limit(1)->first();
        $slug = json_encode($tag->slug);
        $slug = json_decode($slug);

        return [
            'tag_slug' => [
                'description' => "`slug` of serie in `meta.slug` tags' list, example: `{$slug}`",
                'required' => true,
                'example' => $slug,
            ],
        ];
    }

    private function publisher(): array
    {
        $publisher = Publisher::inRandomOrder()->first();

        return [
            'publisher_slug' => [
                'description' => "`slug` of serie in `meta.slug` publishers' list, example: `{$publisher->slug}`",
                'required' => true,
                'example' => $publisher->slug,
            ],
        ];
    }

    private function language(): array
    {
        $language = Language::inRandomOrder()->first();

        return [
            'language_slug' => [
                'description' => "`slug` of serie in `meta.slug` languages' list, example: `{$language->slug}`",
                'required' => true,
                'example' => $language->slug,
            ],
        ];
    }

    private function user(): array
    {
        $user = User::inRandomOrder()->first();

        return [
            'user_slug' => [
                'description' => "`slug` of user in `meta.slug` users' list, example: `{$user->slug}`",
                'required' => true,
                'example' => $user->slug,
            ],
        ];
    }

    private function author_slug(Author $author)
    {
        return [
            'author_slug' => [
                'description' => "`slug` of author in `meta.author` books' list, in case of multiple authors, default author is selected so you need to refer to books' list and not authors' list, example: `{$author->slug}`",
                'required' => true,
                'example' => $author->slug,
            ],
        ];
    }

    private function book_slug(Book $book)
    {
        return [
            'book_slug' => [
                'description' => "`slug` of book in `meta.slug` books' list, example: `{$book->slug}`",
                'required' => true,
                'example' => $book->slug,
            ],
        ];
    }

    private function serie_slug(Serie $serie)
    {
        return [
            'serie_slug' => [
                'description' => "`slug` of serie in `meta.slug` series' list, example: `{$serie->slug}`",
                'required' => true,
                'example' => $serie->slug,
            ],
        ];
    }

    private function post_slug(Post $post)
    {
        return [
            'post_slug' => [
                'description' => "`slug` of post in `meta.slug` posts' list, example: `{$post->slug}`",
                'required' => true,
                'example' => $post->slug,
            ],
        ];
    }

    private function page_slug(Page $page)
    {
        return [
            'page_slug' => [
                'description' => "`slug` of page in `meta.slug` pages' list, example: `{$page->slug}`",
                'required' => true,
                'example' => $page->slug,
            ],
        ];
    }

    private function format()
    {
        return [
            'format' => [
                'description' => 'Format for Book or Book[], if `null` get first format available if format not exist return `404`, to have a format list, check `api.entities.enums`.',
                'required' => false,
                'example' => BookFormatEnum::epub->name,
            ],
        ];
    }
}
