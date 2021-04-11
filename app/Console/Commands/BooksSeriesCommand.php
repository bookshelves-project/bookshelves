<?php

namespace App\Console\Commands;

use App\Models\Serie;
use App\Models\Author;
use Illuminate\Console\Command;
use App\Providers\Bookshelves\ExtraDataGenerator;

class BooksSeriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:series';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $series = Serie::orderBy('title_sort')->get();
        $series->each(function ($query) {
            $query->clearMediaCollection('series');
        });
        foreach ($series as $key => $serie) {
            $serie->description = null;
            $serie->wikipedia_link = null;
            $serie->save();
        }

        // $authors = Author::limit(10)->get();
        $this->alert('Bookshelves: regenerate series extra data');
        $this->info('- Erase description, wikipedia link and picture');
        $this->info('- Regenerate description, wikipedia link and picture: HTTP requests');
        $this->newLine();

        $bar = $this->output->createProgressBar(count($series));
        $bar->start();
        foreach ($series as $key => $serie) {
            ExtraDataGenerator::generateSerieCover($serie);
            ExtraDataGenerator::generateSerieDescription($serie);
            $bar->advance();
        }
        $bar->finish();
        $this->newLine(2);
        $this->info('Extradata regenerated!');

        return 0;
    }
}
