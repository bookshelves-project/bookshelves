<?php

namespace App\Console\Commands\Bookshelves;

use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Serie;
use Illuminate\Console\Command;
use Spatie\Tags\Tag;

class StatsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Statistics of Bookshelves application.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->table(
            ['Books', 'Series', 'Authors', 'Languages', 'Publishers', 'Tags'],
            [[Book::count(), Serie::count(), Author::count(), Language::count(), Publisher::count(), Tag::count()]]
        );
    }
}
