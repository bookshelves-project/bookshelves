<?php

namespace App\Console\Commands\Bookshelves;

use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Serie;
use App\Models\Tag;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\Commandable;

class StatsCommand extends Commandable
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
     *
     * @return int
     */
    public function handle()
    {
        $this->table(
            ['Books', 'Series', 'Authors', 'Languages', 'Publishers', 'Tags'],
            [[Book::query()->count(), Serie::query()->count(), Author::query()->count(), Language::query()->count(), Publisher::query()->count(), Tag::query()->count()]]
        );

        return Command::SUCCESS;
    }
}
