<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class LarastanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larastan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Execute Larastan error check like './vendor/bin/phpstan analyse', rules can be updated in phpstan.neon.dist";

    /**
     * Create a new command instance.
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
        $this->info('Run Larastan');
        $this->info('For more informations check repository at https://github.com/nunomaduro/larastan');

        $process = new Process(['./vendor/bin/phpstan', 'analyse']);
        $process->setTimeout(0);
        $process->start();
        $iterator = $process->getIterator($process::ITER_SKIP_ERR | $process::ITER_KEEP_OUTPUT);
        foreach ($iterator as $data) {
            echo $data;
        }

        return true;
    }
}
