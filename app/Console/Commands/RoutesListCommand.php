<?php

namespace App\Console\Commands;

use App\Services\FileService;
use App\Services\RouteService;
use Illuminate\Console\Command;

class RoutesListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'routes:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all routes into JSON file.';

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
        $list = RouteService::getList();
        FileService::saveAsJson($list, 'routes');

        return 0;
    }
}
