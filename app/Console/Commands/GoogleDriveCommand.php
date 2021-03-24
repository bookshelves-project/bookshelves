<?php

namespace App\Console\Commands;

use Storage;
use Illuminate\Console\Command;

class GoogleDriveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'google-drive';

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
        $files = Storage::disk('google')->download('1IJFmzuARB_99OMav-Vvoj28oBEvxkgvl');
        dd($files);

        return 0;
    }
}
