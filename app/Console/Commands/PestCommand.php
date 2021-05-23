<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class PestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute test from Pest framework';

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
     */
    public function handle(): bool
    {
        $this->info('Run tests');

        // $result = shell_exec('./vendor/bin/pest  --colors');
        // echo $result;

        $process = new Process(['./vendor/bin/pest', '--colors=always']);
        $process->setTimeout(0);
        $process->start();
        $iterator = $process->getIterator($process::ITER_SKIP_ERR | $process::ITER_KEEP_OUTPUT);
        foreach ($iterator as $data) {
            echo $data;
        }
        

        return true;
    }
}
