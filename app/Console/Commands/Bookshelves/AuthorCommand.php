<?php

namespace App\Console\Commands\Bookshelves;

use App\Models\Author;
use Illuminate\Console\Command;
use App\Providers\Bookshelves\AuthorProvider;

class AuthorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:authors
                            {--f|fresh : refresh authors medias, `description` & `wikipedia_link`}';

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
        $isFresh = $this->option('fresh');

        $authors = Author::orderBy('lastname')->get();
        if ($isFresh) {
            $authors->each(function ($query) {
                $query->clearMediaCollection('authors');
            });
            foreach ($authors as $key => $author) {
                $author->description = null;
                $author->wikipedia_link = null;
                $author->save();
            }
        }
        $this->alert('Bookshelves: authors');
        $this->info('- Get pictures and description from Wikipedia: HTTP requests');
        $this->newLine();

        $bar = $this->output->createProgressBar(count($authors));
        $bar->start();
        foreach ($authors as $key => $author) {
            AuthorProvider::descriptionAndPicture(author: $author);
            $bar->advance();
        }
        $bar->finish();
        $this->newLine(2);

        return 0;
    }
}
