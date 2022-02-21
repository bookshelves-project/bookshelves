<?php

namespace App\Console\Commands\Bookshelves;

use App\Services\DirectoryClearService;
use Artisan;
use Illuminate\Console\Command;

class ClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear temporary files from Bookshelves';

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
        $app = config('app.name');
        $this->alert("{$app}: clear");
        $debug = new DirectoryClearService(storage_path('app/public/debug'));
        $cache = new DirectoryClearService(storage_path('app/public/cache'));
        $temp = new DirectoryClearService(storage_path('app/public/temp'));

        $debug->clearDir();
        $cache->clearDir();
        $temp->clearDir();

        Artisan::call('cache:clear', [], $this->getOutput());
        Artisan::call('route:clear', [], $this->getOutput());
        Artisan::call('config:clear', [], $this->getOutput());
        Artisan::call('view:clear', [], $this->getOutput());
        Artisan::call('optimize:clear', [], $this->getOutput());
        $clear = new DirectoryClearService('bootstrap/cache');
        $clear->clearDir();

        $this->newLine();

        return 0;
    }
}
