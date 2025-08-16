<?php

namespace App\Console\Commands\Bookshelves\Duplicates;

use App\Enums\LibraryTypeEnum;
use App\Models\AudiobookTrack;
use App\Models\Book;
use App\Models\Library;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Kiwilan\Steward\Commands\Commandable;

class AudiobookCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:duplicates:audiobook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle audiobooks duplicates.';

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

        Library::where('type', LibraryTypeEnum::audiobook)->each(fn ($library) => $this->parse($library));

        return Command::SUCCESS;
    }

    private function parse(Library $library)
    {
        $this->info("AudiobookCommand: starting for library {$library->name}...");

        $groups = AudiobookTrack::select('slug', DB::raw('COUNT(*) as track_count'))
            ->where('library_id', $library->id)
            ->groupBy('slug')
            ->having('track_count', '>', 1)
            ->get();

        $i = 0;
        foreach ($groups as $group) {
            $book_ids = [];
            $tracks = AudiobookTrack::where('slug', $group->slug)->get();

            foreach ($tracks as $track) {
                $book_ids[] = $track->book_id;
            }

            // Check if `book_ids` are same
            $book_ids = array_unique($book_ids);
            if (count($book_ids) !== 1) {
                $i++;
                $this->handleMultipleBookIds($tracks);
            }
        }

        $this->comment("AudiobookCommand: found {$i} groups with multiple book IDs");
        $this->info("AudiobookCommand: finished for library {$library->name}");
    }

    /**
     * Handle multiple book_ids for an audiobook.
     *
     * @param  Collection<int, AudiobookTrack>  $tracks
     */
    private function handleMultipleBookIds(Collection $tracks): void
    {
        $main_book = $tracks->first()->book_id;

        foreach ($tracks as $track) {
            if ($track->book_id !== $main_book) {
                $wrong_book = $track->book_id;

                $track->book()->dissociate();
                $track->book()->associate($main_book);
                $track->saveQuietly();

                Book::find($wrong_book)?->delete();
            }
        }
    }
}
