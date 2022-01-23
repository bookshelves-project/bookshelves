<?php

namespace App\Console\Commands\Bookshelves;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:cms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute CMS seeders.';

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
        Artisan::call('db:seed', [
            '--class' => 'CmsSeeder',
        ], $this->getOutput());

        return Command::SUCCESS;
    }
}
