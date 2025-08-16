<?php

namespace App\Console\Commands\Bookshelves\Redis;

use App\Models\Author;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Kiwilan\Steward\Commands\Commandable;

class BookshelvesRedisAuthorsCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:redis:authors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Redis clean-up for audiobooks, authors, and series.';

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

        $duplicates = Author::select('slug', DB::raw('COUNT(*) as total'))
            ->groupBy('slug')
            ->having('total', '>', 1)
            ->get();

        $this->table(
            ['Slug', 'Total'],
            $duplicates->toArray()
        );

        return Command::SUCCESS;
    }
}
