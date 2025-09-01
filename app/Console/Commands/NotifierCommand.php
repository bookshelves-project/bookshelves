<?php

namespace App\Console\Commands;

use App\Facades\Bookshelves;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\LaravelNotifier\Facades\Notifier;
use Kiwilan\Steward\Commands\Commandable;

class NotifierCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifier {title} {text?} {image?} {color?} {url?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify about new movies and TV shows.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->title();

        $title = $this->argument('title');
        $text = $this->argument('text') ?: 'New content available.';
        $image = $this->argument('image');
        $color = $this->argument('color');
        $url = $this->argument('url');
        $this->info("Notifying for {$title}.");

        if (! Bookshelves::notifyDiscord()) {
            $this->warn('Discord notifications are disabled.');

            return;
        }

        $notifier = Notifier::discord(Bookshelves::notifyDiscord())
            ->rich($text)
            ->user('Bookshelves', config('app.url').'/android-chrome-512x512.png');

        if ($color) {
            $notifier->color($color);
        } else {
            $notifier->colorSuccess();
        }

        if ($title) {
            $notifier->title($title);
        }

        if ($image) {
            $notifier->image($image);
        }

        if ($url) {
            $notifier->url($url);
        }

        $notifier->send();
    }

    public static function book(Book $book): void
    {
        if (! $book->to_notify) {
            return;
        }

        $book->refresh();
        $book->loadMissing(['authors', 'library', 'serie', 'media']);

        if ($book->serie?->title === null) {
            Journal::warning("{$book->title} no series");
            $book->to_notify = false;
            $book->saveNoSearch();

            return;
        }

        $book->to_notify = false;
        $book->saveNoSearch();

        Artisan::call(NotifierCommand::class, [
            'title' => "{$book->title} - {$book->library->name}",
            'text' => "{$book->authors_names}",
            'image' => $book->cover_thumbnail,
            'color' => $book->cover_color,
            'url' => $book->route,
        ]);
        Journal::warning("Notified for {$book->title}.", [
            'title' => "{$book->title} - {$book->library->name}",
            'text' => "{$book->authors_names}",
            'image' => $book->cover_thumbnail,
            'color' => $book->cover_color,
            'url' => $book->route,
        ]);
    }

    public static function serie(Serie $serie): void
    {
        $serie->refresh();
        $serie->loadMissing(['books', 'authors', 'library']);
        $serie->loadCount('books');

        $to_notify = $serie->books->filter(fn ($book) => $book->to_notify);

        if ($to_notify->count() === 0) {
            return;
        }

        foreach ($serie->books as $book) {
            $book->to_notify = false;
            $book->saveNoSearch();
        }

        Artisan::call(NotifierCommand::class, [
            'title' => "{$serie->title} - {$serie->library->name}",
            'text' => "{$serie->books_count} books by {$serie->authors_names}",
            'image' => $serie->cover_thumbnail,
            'color' => $serie->cover_color,
            'url' => $serie->route,
        ]);
        Journal::warning("Notified for {$serie->title}.", [
            'title' => "{$serie->title} - {$serie->library->name}",
            'text' => "{$serie->books_count} books by {$serie->authors_names}",
            'image' => $serie->cover_thumbnail,
            'color' => $serie->cover_color,
            'url' => $serie->route,
        ]);
    }
}
