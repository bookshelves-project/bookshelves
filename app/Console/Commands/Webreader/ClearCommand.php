<?php

namespace App\Console\Commands\Webreader;

use App\Utils\ClearFileTools;
use Illuminate\Console\Command;

class ClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'webreader:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $dir = 'public/storage/webreader';
        $file = new ClearFileTools($dir);
        $file->clearDir();

        return 0;
    }
}
