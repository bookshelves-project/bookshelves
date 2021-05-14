<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class DatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup database';

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
        $this->info('Database migration...');
        if ($this->confirm('Do you want to migrate fresh database? /* THIS WILL ERASE ALL DATA */', false)) {
            Artisan::call('migrate:fresh --force', [], $this->getOutput());

            $this->newLine();
            $this->line('~ Database successfully migrated.');
        }

        return 0;
    }
}
