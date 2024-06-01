<?php

namespace App\Console\Commands\Bookshelves;

use App\Jobs\Book\BooksDispatchJob;
use App\Jobs\Library\ParserJob;
use App\Models\Library;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Kiwilan\LaravelNotifier\Facades\Journal;
use Kiwilan\Steward\Commands\Commandable;

/**
 * Main command of Bookshelves to generate Books with relations.
 */
class LibraryCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:library
                            {library-slug : Library slug to parse}
                            {--f|fresh : Fresh parsing}
                            {--l|limit= : Limit epub files to generate, useful for debug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse library to generate Books with relations.';

    /**
     * Create a new command instance.
     */
    public function __construct(
        protected ?string $librarySlug = null,
        protected bool $fresh = false,
        protected ?int $limit = null,
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

        $this->librarySlug = (string) $this->argument('library-slug');
        $this->fresh = $this->option('fresh') ?: false;
        $this->limit = $this->optionInt('limit') ?: null;

        $library = Library::query()->where('slug', $this->librarySlug)->first();
        if (! $library || ! $library instanceof Library) {
            $libraries = Library::inOrder()->map(fn (Library $library) => $library->slug)->toArray();
            $librariesStr = implode(', ', $libraries);
            $msg = "LibraryCommand: library not found: {$this->librarySlug}, available: {$librariesStr}";
            Journal::error($msg);
            $this->error($msg);

            return Command::FAILURE;
        }

        $this->info("Parsing library: {$library->name}...");
        $this->comment('Fresh: '.($this->fresh ? 'yes' : 'no'));
        $this->comment('Limit: '.($this->limit ?: 'no limit'));

        if ($this->fresh) {
            $this->deleteModels($library->files);
            $this->deleteModels($library->books);
            $this->deleteModels($library->audiobookTracks);
            $this->deleteModels($library->series);
        }

        ParserJob::dispatch($library, $this->limit);
        BooksDispatchJob::dispatch($library);

        return Command::SUCCESS;
    }

    private function deleteModels(Collection $models): void
    {
        $models->each(fn (Model $model) => $model->delete());
    }
}
