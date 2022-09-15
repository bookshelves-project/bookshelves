<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Artisan;
use Illuminate\Console\Command;
use ReflectionClass;

class ScoutFreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:fresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage models to search engine with Laravel Scout.';

    protected $models = [];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->alert($this->signature);
        $this->warn($this->description);

        $list = [
            Book::class,
            Serie::class,
            Author::class,
        ];
        foreach ($list as $model) {
            $this->getScoutName($model);
        }

        try {
            foreach ($this->models as $key => $value) {
                Artisan::call('scout:flush "'.$key.'"', [], $this->getOutput());
                Artisan::call('scout:delete-index "'.$value.'"', [], $this->getOutput());
            }

            foreach ($this->models as $key => $value) {
                Artisan::call('scout:import "'.$key.'"', [], $this->getOutput());
            }
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }

        return 0;
    }

    public function getScoutName(string $model)
    {
        $instance = new $model();
        $class = new ReflectionClass($instance);
        $name = str_replace('\\', '\\\\', $class->getName());
        $this->models[$name] = $instance->searchableAs();
    }
}
