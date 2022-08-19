<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\Book;
use App\Models\Serie;
use Artisan;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
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
            new Book(),
            new Serie(),
            new Author(),
        ];
        foreach ($list as $value) {
            $this->getScoutName($value);
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

    public function getScoutName(Model $instance)
    {
        $class = new ReflectionClass($instance);
        $name = str_replace('\\', '\\\\', $class->getName());
        // @phpstan-ignore-next-line
        $this->models[$name] = $instance->searchableAs();
    }
}
