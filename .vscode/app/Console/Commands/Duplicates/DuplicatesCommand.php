<?php

namespace App\Console\Commands\Bookshelves\Duplicates;

use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Kiwilan\Steward\Commands\Commandable;

class DuplicatesCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:duplicates
                            {--c|clean : Execute clean commands}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find duplicate entries in the database for authors, series, and books.';

    /**
     * Create a new command instance.
     */
    public function __construct(
        protected bool $verbose = false,
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

        $clean = $this->optionBool('clean');
        $this->verbose = $this->optionBool('verbose');

        $this->find(Author::class, column: 'slug', name: 'authors');
        $this->find(Serie::class, column: 'slug', name: 'series', with_library: true);
        $this->find(Book::class, column: 'slug', name: 'books', with_library: true);

        if ($clean) {
            $this->info('Executing clean commands...');
            Artisan::call(AudiobookCommand::class);
            $this->comment(Artisan::output());

            Artisan::call(SerieCommand::class);
            $this->comment(Artisan::output());

            Artisan::call(AuthorCommand::class);
            $this->comment(Artisan::output());
            $this->info('Clean commands executed successfully.');
        }

        return Command::SUCCESS;
    }

    private function find(string $class, string $column, string $name, bool $with_library = false): void
    {
        if ($with_library) {
            $duplicates = $class::select('slug', 'library_id', DB::raw('COUNT(*) as total'))
                ->groupBy('slug', 'library_id')
                ->having('total', '>', 1)
                ->get();
        } else {
            $duplicates = $class::select($column, DB::raw('COUNT(*) as total'))
                ->groupBy($column)
                ->having('total', '>', 1)
                ->get();
        }

        if ($duplicates->isEmpty()) {
            $this->info("No duplicate {$name} found.");
            $this->newLine();

            return;
        }

        if ($this->verbose) {
            if ($with_library) {
                $this->table(
                    ['Slug', 'Library ID', 'Total'],
                    $duplicates->map(fn ($duplicate) => [
                        $duplicate->{$column},
                        $duplicate->library_id,
                        $duplicate->total,
                    ])->toArray()
                );
            } else {
                $this->table(
                    ['Slug', 'Total'],
                    $duplicates->map(fn ($duplicate) => [
                        $duplicate->{$column},
                        $duplicate->total,
                    ])->toArray()
                );
            }
        }

        $this->info("Found {$duplicates->count()} duplicate {$name}.");
        $this->newLine();
    }
}
