<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use Kiwilan\Steward\Commands\CommandSteward;
use Kiwilan\Steward\Services\DirectoryClearService;

class ClearAllCommand extends CommandSteward
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:all
                            {--p|production : cache after clear}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear temporary files and cache.';

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
        $this->warn('Clear full');
        $this->newLine();

        $prod = $this->option('production') ?? false;

        DirectoryClearService::make([
            storage_path('app/public/cache'),
            storage_path('app/public/debug'),
            'bootstrap/cache',
        ]);

        Artisan::call('cache:clear', [], $this->getOutput());
        Artisan::call('route:clear', [], $this->getOutput());
        Artisan::call('config:clear', [], $this->getOutput());
        Artisan::call('view:clear', [], $this->getOutput());
        Artisan::call('optimize:clear', [], $this->getOutput());

        if ($prod) {
            Artisan::call('route:cache', [], $this->getOutput());
            Artisan::call('config:cache', [], $this->getOutput());
            Artisan::call('view:cache', [], $this->getOutput());
            Artisan::call('optimize', [], $this->getOutput());
        }

        return Command::SUCCESS;
    }
}
