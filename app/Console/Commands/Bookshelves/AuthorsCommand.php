<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\AuthorJob;
use App\Models\Author;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

class AuthorsCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:authors
                            {--f|fresh : reset authors relations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Improve authors.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->title();

        $fresh = $this->option('fresh') ?: false;

        $authors = Author::query()
            ->where('wikipedia_parsed_at', null)
            ->orWhere('wikipedia_parsed_at', '>', now()->subYear())
            ->get();

        foreach ($authors as $author) {
            AuthorJob::dispatch($author, $fresh);
        }
    }
}
