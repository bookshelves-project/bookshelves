<?php

namespace App\Console\Commands\Bookshelves;

use Cache;
use App\Models\Serie;
use Illuminate\Console\Command;
use App\Providers\Bookshelves\SerieProvider;

class SerieCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:series
                            {--a|alone : prevent external HTTP requests to public API for additional informations}
                            {--f|fresh : refresh series medias, `description` & `description_link`}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate cover, language and description for `Serie`.';

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
        Cache::forget('series');

        $isFresh = $this->option('fresh');
        $alone = $this->option('alone');

        $series = Serie::orderBy('title_sort')->get();
        if ($isFresh) {
            $series->each(function ($query) {
                $query->clearMediaCollection('series');
            });
            foreach ($series as $key => $serie) {
                $serie->description = null;
                $serie->description_link = null;
                $serie->save();
            }
        }
        $this->alert('Bookshelves: series');
        $this->info('- Get cover of vol. 1 to associate picture to serie if exist');
        $this->info("- If a JPG file with slug of serie exist in 'public/storage/raw/covers-series', it's will be this picture");
        $this->info('- Get description, description link: HTTP requests');
        $this->newLine();

        $bar = $this->output->createProgressBar(count($series));
        $bar->start();
        foreach ($series as $key => $serie) {
            SerieProvider::cover(serie: $serie);
            SerieProvider::language(serie: $serie);
            if (!$alone) {
                SerieProvider::description(serie: $serie);
            }
            
            $bar->advance();
        }
        $bar->finish();
        $this->newLine(2);

        return 0;
    }
}
