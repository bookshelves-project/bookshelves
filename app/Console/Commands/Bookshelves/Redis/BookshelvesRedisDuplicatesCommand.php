<?php

namespace App\Console\Commands\Bookshelves\Redis;

use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Kiwilan\Steward\Commands\Commandable;

class BookshelvesRedisDuplicatesCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:redis:duplicates';

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

        $duplicates = Serie::select('slug', DB::raw('COUNT(*) as total'))
            ->groupBy('slug')
            ->having('total', '>', 1)
            ->get();
        $this->info("Found {$duplicates->count()} duplicate series.");

        // $this->find(Author::class, column: 'slug', name: 'authors');
        // $this->find(Serie::class, column: 'slug', name: 'series');
        // $this->find(Book::class, column: 'slug', name: 'books');

        return Command::SUCCESS;
    }

    private function find(string $class, string $column, string $name): void
    {
        try {
            $duplicates = $class::select($column, DB::raw('COUNT(*) as total'))
                ->groupBy($column)
                ->having('total', '>', 1)
                ->get();
        } catch (\Throwable $th) {
            $this->error("Error finding {$name}: {$th->getMessage()}");

            return;
        }

        if ($duplicates->isEmpty()) {
            $this->info("No duplicate {$name} found.");

            return;
        }

        $this->table(
            ['Slug', 'Total'],
            $duplicates->toArray()
        );
    }
}
