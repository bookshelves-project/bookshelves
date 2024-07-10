<?php

namespace App\Console\Commands;

use App\Facades\Bookshelves;
use App\Models\Book;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Kiwilan\LaravelNotifier\Facades\Notifier;
use Kiwilan\Steward\Commands\Commandable;

class NotifierCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifier {title} {text} {image} {color} {url}';

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

    public static function make(Book $book): void
    {
        $book->refresh();
        if ($book->is_notified) {
            return;
        }

        $title = "{$book->title}";
        $text = $book->serie
            ? "{$book->serie->title} #{$book->volume_pad} by {$book->authors_names}"
            : $book->authors_names;
        $image = $book->cover;
        $color = $book->cover_color;
        $url = $book->route;

        $book->is_notified = true;
        $book->saveNoSearch();

        Artisan::call(NotifierCommand::class, [
            'title' => $title,
            'text' => $text,
            'image' => $image,
            'color' => $color,
            'url' => $url,
        ]);
    }
}
