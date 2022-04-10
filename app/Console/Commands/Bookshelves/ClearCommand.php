<?php

namespace App\Console\Commands\Bookshelves;

use App\Console\CommandProd;
use App\Services\DirectoryClearService;
use Artisan;
use Illuminate\Console\Command;

class ClearCommand extends CommandProd
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
        $this->warn('Bookshelves Clear');
        $this->newLine();

        $debug = new DirectoryClearService(storage_path('app/public/debug'));
        $cache = new DirectoryClearService(storage_path('app/public/cache'));

        $debug->clearDir();
        $cache->clearDir();

        Artisan::call('cache:clear', [], $this->getOutput());
        Artisan::call('route:clear', [], $this->getOutput());
        Artisan::call('config:clear', [], $this->getOutput());
        Artisan::call('view:clear', [], $this->getOutput());
        Artisan::call('optimize:clear', [], $this->getOutput());
        $clear = new DirectoryClearService('bootstrap/cache');
        $clear->clearDir();

        return 0;
    }
}
