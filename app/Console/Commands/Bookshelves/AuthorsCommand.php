<?php

namespace App\Console\Commands\Bookshelves;

use App\Models\Author;
use Illuminate\Console\Command;
use App\Providers\Bookshelves\AuthorProvider;

class AuthorsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:authors
                            {--L|local : prevent external HTTP requests to public API for additional informations}
                            {--f|fresh : refresh authors medias, `description` & `link`}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate cover, language and description for `Author`.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fresh = $this->option('fresh') ?? false;
        $local = $this->option('local') ?? false;

        $authors = Author::orderBy('lastname')->get();
        if ($fresh) {
            $authors->each(function ($query) {
                $query->clearMediaCollection('authors');
            });
            foreach ($authors as $key => $author) {
                $author->description = null;
                $author->link = null;
                $author->save();
            }
        }
        $this->alert('Bookshelves: authors');
        if (! $local) {
            $this->info('- Get pictures and description from Wikipedia: HTTP requests (--local to skip)');
            $this->info('- Take description and link from public/storage/raw/authors.json if exists');
        } else {
            $this->info('- Take description and link from public/storage/raw/authors.json if exists');
        }
        $this->info("- If a JPG file with slug of serie exist in 'public/storage/raw/pictures-authors', it's will be this picture");
        $this->newLine();

        $bar = $this->output->createProgressBar(count($authors));
        $bar->start();
        foreach ($authors as $key => $author) {
            AuthorProvider::tags($author);
            if (! $author->description && ! $author->link) {
                AuthorProvider::descriptionAndPicture(author: $author, local: $local);
            }
            $bar->advance();
        }
        $bar->finish();
        $this->newLine(2);

        return 0;
    }
}
