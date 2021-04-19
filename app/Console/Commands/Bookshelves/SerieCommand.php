<?php

namespace App\Console\Commands\Bookshelves;

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
                            {--f|fresh : refresh series medias, `description` & `wikipedia_link`}';

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
        $isFresh = $this->option('fresh');

        $series = Serie::orderBy('title_sort')->get();
        if ($isFresh) {
            $series->each(function ($query) {
                $query->clearMediaCollection('series');
            });
            foreach ($series as $key => $serie) {
                $serie->description = null;
                $serie->wikipedia_link = null;
                $serie->save();
            }
        }
        $this->alert('Bookshelves: series');
        $this->info('- Get cover of vol. 1 to associate picture to serie if exist');
        $this->info("- If a JPG file with slug of serie exist in 'database/seeders/media/series', it's will be this picture");
        $this->info('- Get description, wikipedia link: HTTP requests');
        $this->newLine();

        $bar = $this->output->createProgressBar(count($series));
        $bar->start();
        foreach ($series as $key => $serie) {
            SerieProvider::cover(serie: $serie);
            SerieProvider::language(serie: $serie);
            SerieProvider::description(serie: $serie);
            $bar->advance();
        }
        $bar->finish();
        $this->newLine(2);

        return 0;
    }
}
