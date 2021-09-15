<?php

namespace App\Console\Commands\Bookshelves;

use App\Models\Serie;
use Illuminate\Console\Command;
use App\Providers\BookshelvesConverter\SerieConverter;

class SeriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:series
                            {--L|local : prevent external HTTP requests to public API for additional informations}
                            {--f|fresh : refresh series medias, `description` & `link`}
                            {--D|default : use default cover for all (skip covers step)}';

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
        $fresh = $this->option('fresh');
        $local = $this->option('local');
        $default = $this->option('default') ?? false;

        $series = Serie::orderBy('title_sort')->get();
        if ($fresh) {
            $series->each(function ($query) {
                $query->clearMediaCollection('series');
            });
            foreach ($series as $key => $serie) {
                $serie->description = null;
                $serie->link = null;
                $serie->save();
            }
        }
        $this->alert('Bookshelves: series assets');
        $this->info('- Get cover of vol. 1 (or next) to associate picture to serie if exist');
        $this->info("- If a JPG file with slug of serie exist in 'public/storage/raw/pictures-series', it's will be this picture");
        if (! $local) {
            $this->info('- Get description, link: HTTP requests (--local to skip)');
            $this->info('- Take description and link from public/storage/raw/series.json if exists');
        } else {
            $this->info('- Take description and link from public/storage/raw/series.json if exists');
        }
        $this->newLine();

        $bar = $this->output->createProgressBar(count($series));
        $bar->start();
        foreach ($series as $key => $serie) {
            SerieConverter::setTags(serie: $serie);
            if (empty($serie->getFirstMediaUrl('series')) && ! $default) {
                SerieConverter::setCover(serie: $serie);
            }
            if (! $serie->description && ! $serie->link) {
                if (! $local) {
                    $result = SerieConverter::setLocalDescription(serie: $serie);
                    if (! $result) {
                        SerieConverter::setDescription(serie: $serie);
                    }
                } else {
                    SerieConverter::setLocalDescription(serie: $serie);
                }
            }
            $bar->advance();
        }
        $bar->finish();
        $this->newLine(2);

        return 0;
    }
}
