<?php

namespace App\Console\Commands\Bookshelves\Duplicates;

use App\Models\Author;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Kiwilan\Steward\Commands\Commandable;

class AuthorCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:duplicates:author';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle author duplicates.';

    /**
     * Create a new command instance.
     */
    public function __construct(
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->title();

        $this->parse();

        return Command::SUCCESS;
    }

    private function parse(): void
    {
        $this->info('RedisAuthorsJob: starting...');

        // Identify duplicate slugs
        $duplicateSlugs = Author::select('slug', DB::raw('COUNT(*) as author_count'))
            ->groupBy('slug')
            ->having('author_count', '>', 1)
            ->pluck('slug');

        DB::transaction(function () use ($duplicateSlugs) {
            $i = 0;
            foreach ($duplicateSlugs as $slug) {
                $i++;
                $this->handleAuthor($slug);
            }

            $this->comment("RedisAuthorsJob: found {$i} duplicate authors");
        });

        $this->info('RedisAuthorsJob: finished');
    }

    private function handleAuthor(string $slug): void
    {
        // Get all authors with this slug
        $authors = Author::where('slug', $slug)->get();

        // Choose the first as main
        $mainAuthor = $authors->shift();

        foreach ($authors as $duplicate) {
            // Attach Books (MorphToMany)
            $bookIds = $duplicate->books()->pluck('id')->toArray();
            if (! empty($bookIds)) {
                $mainAuthor->books()->syncWithoutDetaching($bookIds);
            }

            // Attach Series (MorphToMany)
            $serieIds = $duplicate->series()->pluck('id')->toArray();
            if (! empty($serieIds)) {
                $mainAuthor->series()->syncWithoutDetaching($serieIds);
            }

            // Delete duplicate author
            $duplicate->delete();
        }
    }
}
