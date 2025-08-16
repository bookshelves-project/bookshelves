<?php

namespace App\Console\Commands\Bookshelves\Duplicates;

use App\Engines\Book\Converter\SerieConverter;
use App\Models\Library;
use App\Models\Serie;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Kiwilan\Steward\Commands\Commandable;

class SerieCommand extends Commandable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:duplicates:serie
                            {--fresh : Whether to force fresh conversion}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle series duplicates.';

    /**
     * Create a new command instance.
     */
    public function __construct(
        public bool $fresh = false,
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
        $this->fresh = $this->option('fresh');

        Library::all()->each(fn ($library) => $this->parse($library));

        return Command::SUCCESS;
    }

    private function parse(Library $library)
    {
        $this->info("SerieCommand: starting for library {$library->name}...");

        // Identify duplicate slugs
        $duplicateSlugs = Serie::select('slug', DB::raw('COUNT(*) as serie_count'))
            ->where('library_id', $library->id)
            ->groupBy('slug')
            ->having('serie_count', '>', 1)
            ->pluck('slug');

        DB::transaction(function () use ($duplicateSlugs) {
            $i = 0;
            foreach ($duplicateSlugs as $slug) {
                $i++;
                $this->handleSerie($slug);
            }

            $this->comment("SerieCommand: found {$i} duplicate series");
        });

        Serie::all()->each(function (Serie $serie) {
            SerieConverter::make($serie, $this->fresh);
        });

        $this->info("SerieCommand: finished for library: {$library->name}");
    }

    private function handleSerie(string $slug): void
    {
        // Get all series with this slug
        $series = Serie::where('slug', $slug)->get();

        // Choose the first as main
        $mainSerie = $series->shift();

        foreach ($series as $duplicate) {
            // Attach Books HasMany to the main Serie
            foreach ($duplicate->books as $book) {
                $book->serie_id = $mainSerie->id;
                $book->save();
            }

            // Attach Authors MorphToMany to the main Serie
            $authorIds = $duplicate->authors()->pluck('id')->toArray();
            if (! empty($authorIds)) {
                $mainSerie->authors()->syncWithoutDetaching($authorIds);
            }

            // Delete duplicate serie
            $duplicate->delete();
        }
    }
}
