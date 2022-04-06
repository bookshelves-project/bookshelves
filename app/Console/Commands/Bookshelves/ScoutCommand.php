<?php

namespace App\Console\Commands\Bookshelves;

use App\Console\CommandProd;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ScoutCommand extends CommandProd
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:scout
                            {--f|flush : remove all models from indexes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add or remove models to search engine with Laravel Scout.';

    /**
     * Create a new command instance.
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
        $this->intro('scout');

        $flush = $this->option('flush') ?? false;

        $models = [
            'Book' => 'books',
            'Serie' => 'series',
            'Author' => 'authors',
        ];
        $path = 'App\\\\Models\\\\';

        // $this->clear();
        if ($flush) {
            foreach ($models as $key => $value) {
                Artisan::call('scout:flush "'.$path.$key.'"', [], $this->getOutput());
                Artisan::call('scout:delete-index "'.$value.'"', [], $this->getOutput());
            }
        }
        foreach ($models as $key => $value) {
            Artisan::call('scout:import "'.$path.$key.'"', [], $this->getOutput());
        }
        // $this->clear();

        return 0;
    }

    public function clear()
    {
        Artisan::call('cache:clear', [], $this->getOutput());
        Artisan::call('route:clear', [], $this->getOutput());
        Artisan::call('config:cache', [], $this->getOutput());
    }
}
