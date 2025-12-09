<?php

namespace App\Engines\Relations;

use App\Engines\Converter\Modules\LanguageModule;
use App\Models\Book;
use App\Models\Language;
use App\Utils;
use Kiwilan\LaravelNotifier\Facades\Journal;

class LanguageRelation
{
    public static function handle(): void
    {
        Journal::info('LanguageRelation: handle languages...');

        $self = new LanguageRelation;
        $self->createLanguages();
        $self->attachLanguages();
    }

    private function createLanguages(): void
    {
        $items = collect();
        Book::all()->each(function (Book $book) use ($items) {
            $index_path = $book->getIndexLanguagePath();
            if (! file_exists($index_path)) {
                return;
            }
            $data = Utils::unserialize($index_path);
            $items->add($data);
        });

        $items = $items->unique(fn ($language) => $language)->values();

        $items->each(function ($language) {
            LanguageModule::make($language);
        });
    }

    private function attachLanguages(): void
    {
        Book::all()->each(function (Book $book) {
            $index_path = $book->getIndexLanguagePath();
            if (! file_exists($index_path)) {
                return;
            }
            $data = Utils::unserialize($index_path);

            $language = Language::where('slug', $data)->first();
            if (! $language) {
                $language = Language::where('name', $data)->first();
            }

            $book->language()->associate($language);
            $book->saveNoSearch();
        });
    }
}
