<?php

namespace App\Console\Commands;

use App\Services\RouteService;
use Illuminate\Console\Command;
use App\Services\ConverterService;

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
        ConverterService::saveAsJson($list, 'routes');

        return 0;
    }
}
