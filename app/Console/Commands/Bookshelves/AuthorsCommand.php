<?php

namespace App\Console\Commands\Bookshelves;

use Artisan;
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
                            {--a|alone : prevent external HTTP requests to public API for additional informations}
                            {--c|covers : prevent generation of covers}
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
        $fresh = $this->option('fresh');
        $no_covers = $this->option('covers');
        $alone = $this->option('alone');

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
        if (! $alone) {
            $this->info('- Get pictures and description from Wikipedia: HTTP requests');
            $this->info('- Take description and link from public/storage/raw/authors.json if exists');
        } else {
            $this->info('- Take description and link from public/storage/raw/authors.json if exists');
        }
        $this->info("- If a JPG file with slug of serie exist in 'public/storage/raw/pictures-authors', it's will be this picture");
        $this->newLine();

        $bar = $this->output->createProgressBar(count($authors));
        $bar->start();
        foreach ($authors as $key => $author) {
            if (! $author->description && ! $author->link) {
                AuthorProvider::descriptionAndPicture(author: $author, alone: $alone, no_cover: $no_covers);
            }
            $bar->advance();
        }
        $bar->finish();
        $this->newLine(2);

        Artisan::call('bookshelves:clear', [], $this->getOutput());

        return 0;
    }
}
