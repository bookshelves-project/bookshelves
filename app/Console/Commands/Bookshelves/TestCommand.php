<?php

namespace App\Console\Commands\Bookshelves;

use Artisan;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:test';

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
        // shell_exec('php artisan config:cache --env=testing');
        // Artisan::call('migrate:fresh', []);
        shell_exec('php artisan test');
        // shell_exec('php artisan config:cache');

        return 0;
    }
}
