<?php

namespace App\Engines\Relations;

use App\Engines\Converter\Modules\TagModule;
use App\Models\Book;
use App\Models\Tag;
use App\Utils;
use Kiwilan\LaravelNotifier\Facades\Journal;

class TagRelation
{
    public static function handle(): void
    {
        Journal::info('TagRelation: handle tags...');

        $self = new TagRelation;
        $self->createTags();
        $self->attachTags();
    }

    private function createTags(): void
    {
        $items = collect();
        Book::all()->each(function (Book $book) use ($items) {
            $index_path = $book->getIndexTagPath();
            if (! file_exists($index_path)) {
                return;
            }
            $tags = Utils::unserialize($index_path);
            $items->push(...$tags);
        });

        $items = $items->unique(fn ($tag) => $tag)->values();
        $items->each(function ($tag) {
            TagModule::make($tag);
        });
    }

    private function attachTags(): void
    {
        Book::all()->each(function (Book $book) {
            $index_path = $book->getIndexTagPath();
            if (! file_exists($index_path)) {
                return;
            }
            $tags = Utils::unserialize($index_path);

            $items = [];
            foreach ($tags as $tag) {
                $items[] = Tag::where('slug', $tag)->first();
            }

            $items = array_values(array_filter($items));
            $book->tags()->sync($items);
        });
    }
}
