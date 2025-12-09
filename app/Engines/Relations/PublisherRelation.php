<?php

namespace App\Engines\Relations;

use App\Engines\Converter\Modules\PublisherModule;
use App\Models\Book;
use App\Models\Publisher;
use App\Utils;
use Kiwilan\LaravelNotifier\Facades\Journal;

class PublisherRelation
{
    public static function handle(): void
    {
        Journal::info('PublisherRelation: handle publishers...');

        $self = new PublisherRelation;
        $self->createPublishers();
        $self->attachPublishers();
    }

    private function createPublishers(): void
    {
        $items = collect();
        Book::all()->each(function (Book $book) use ($items) {
            $index_path = $book->getIndexPublisherPath();
            if (! file_exists($index_path)) {
                return;
            }
            $data = Utils::unserialize($index_path);
            $items->add($data);
        });

        $items = $items->unique(fn ($publisher) => $publisher)->values();
        $items->each(function ($publisher) {
            PublisherModule::make($publisher);
        });
    }

    private function attachPublishers(): void
    {
        Book::all()->each(function (Book $book) {
            $index_path = $book->getIndexPublisherPath();
            if (! file_exists($index_path)) {
                return;
            }
            $data = Utils::unserialize($index_path);
            $publisher = Publisher::where('name', $data)->first();

            if ($publisher) {
                $book->publisher()->associate($publisher);
                $book->saveNoSearch();
            }
        });
    }
}
