<?php

namespace App\Docs\Strategies;

use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
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
            'authors.download' => 'author',
            'books.show' => 'book',
            'books.related' => 'book',
            'books.download' => 'book',
            'download.book' => 'book',
            'download.serie' => 'serie',
            'download.author' => 'author',
            'languages.show' => 'language',
            'publishers.show' => 'publisher',
            'publishers.show.books' => 'publisher',
            'series.show' => 'serie',
            'series.show.books' => 'serie',
            'series.current' => 'serieVolume',
            'series.download' => 'serie',
            'tags.show' => 'tag',
            'tags.show.books' => 'tag',
            'users.show' => 'user',
            'users.comments' => 'user',
            'users.favorites' => 'user',
        ];

        foreach ($routes as $name => $method) {
            if ("api.v1.{$name}" === $this->routeName) {
                $this->urlParams = $this->{$method}();
            }
        }
    }

    private function author(): array
    {
        $author = Author::inRandomOrder()->first();

        return [
            'author_slug' => [
                'description' => "`slug` of author in `meta.slug` authors' list, example: `{$author->slug}`",
                'required' => true,
                'example' => $author->slug,
            ],
        ];
    }

    private function book(): array
    {
        $book = Book::inRandomOrder()->first();

        return [
            'author_slug' => [
                'description' => "`slug` of author in `meta.author` books' list, in case of multiple authors, default author is selected so you need to refer to books' list and not authors' list, example: `{$book->meta_author}`",
                'required' => true,
                'example' => $book->meta_author,
            ],
            'book_slug' => [
                'description' => "`slug` of book in `meta.slug` books' list, example: `{$book->slug}`",
                'required' => true,
                'example' => $book->slug,
            ],
        ];
    }

    private function serie(): array
    {
        $serie = Serie::inRandomOrder()->first();

        return [
            'author_slug' => [
                'description' => "`slug` of author in `meta.author` series' list, in case of multiple authors, default author is selected so you need to refer to series' list and not authors' list, example: `{$serie->meta_author}`",
                'required' => true,
                'example' => $serie->meta_author,
            ],
            'serie_slug' => [
                'description' => "`slug` of serie in `meta.slug` series' list, example: `{$serie->slug}`",
                'required' => true,
                'example' => $serie->slug,
            ],
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
}
